<?php

namespace App\Providers;

use App\Docs\DocumentationContentParser;
use App\Docs\DocumentationPage;
use App\Docs\DocumentationPathParser;
use App\Docs\DocumentationRepository;
use App\Jobs\ImportDocsForRepositoryJob;
use App\Jobs\Middleware\ThrottleScreenshots;
use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use App\Models\HtmlLesson;
use App\Models\Video;
use App\Spotlight\DocsCommand;
use App\Spotlight\Spotlight;
use App\Support\Search\CrawlSiteJob;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use LivewireUI\Spotlight\SpotlightServiceProvider;
use Spatie\Flash\Flash;
use Spatie\MediaLibrary\Conversions\Jobs\PerformConversionsJob;
use Spatie\MediaLibrary\ResponsiveImages\Jobs\GenerateResponsiveImagesJob;
use Spatie\OgImage\Facades\OgImage;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layout.partials.meta', function ($view) {
            $data = $view->getData();
            $title = $data['ogImageTitle'] ?? $data['title'] ?? null;
            if ($title) {
                app()->instance('page.og-image-title', $title);
            }
        });

        OgImage::fallbackUsing(fn (Request $request) => view('og-image.fallback', [
            'title' => app()->bound('page.og-image-title') ? app('page.og-image-title') : 'Solid expertise <br> in Laravel &amp; AI',
        ]));

        $this->routeLongRunningJobs();

        RateLimiter::for(ThrottleScreenshots::RATE_LIMITER, function () {
            if (config('laravel-screenshot.driver') !== 'cloudflare') {
                return Limit::none();
            }

            return Limit::perSecond(1, 20);
        });
    }

    /**
     * Jobs that can run longer than the 90 seconds a Flex managed queue on Laravel Cloud
     * allows go to a separate queue, which is served by a Pro managed queue on Cloud.
     */
    protected function routeLongRunningJobs(): void
    {
        Queue::route([
            CrawlSiteJob::class => 'long-running',
            RandomizeAdsOnGitHubRepositoriesJob::class => 'long-running',
            ImportDocsForRepositoryJob::class => 'long-running',
            PerformConversionsJob::class => 'long-running',
            GenerateResponsiveImagesJob::class => 'long-running',
        ]);
    }

    public function register(): void
    {
        $this->app->register(SpotlightServiceProvider::class);

        Model::unguard();

        Flash::levels([
            'success' => 'success',
            'error' => 'error',
        ]);

        foreach (config('docs.repositories') as $docsRepository) {
            config()->set("sheets.collections.{$docsRepository['name']}", [
                'repository' => DocumentationRepository::class,
                'repository_name' => $docsRepository['name'],
                'sheet_class' => DocumentationPage::class,
                'path_parser' => DocumentationPathParser::class,
                'content_parser' => DocumentationContentParser::class,
            ]);
        }

        Relation::morphMap([
            'video' => Video::class,
            'htmlLesson' => HtmlLesson::class,
        ]);


        Livewire::component('spotlight', Spotlight::class);

        foreach (collect(config('docs.repositories'))->sortBy('name') as $repository) {
            Spotlight::registerInstantiatedCommand(new DocsCommand($repository));
        }
    }
}
