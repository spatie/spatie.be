<?php

namespace App\Providers;

use App\Models\HtmlLesson;
use App\Models\Video;
use App\Spotlight\DocsCommand;
use App\Spotlight\Spotlight;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Model::unguard();

        Flash::levels([
            'success' => 'success',
            'error' => 'error',
        ]);

        foreach (config('docs.repositories') as $docsRepository) {
            config()->set("filesystems.disks.{$docsRepository['name']}", [
                'driver' => 'local',
                'root' => storage_path("docs/{$docsRepository['name']}"),
            ]);

            config()->set("sheets.collections.{$docsRepository['name']}", [
                'disk' => $docsRepository['name'],
                'sheet_class' => \App\Docs\DocumentationPage::class,
                'path_parser' => \App\Docs\DocumentationPathParser::class,
                'content_parser' => \App\Docs\DocumentationContentParser::class,
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
