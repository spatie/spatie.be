<?php

namespace App\Providers;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Model::unguard();

        Gate::define('viewMailcoach', function ($user = null) {
            return optional($user)->is_admin;
        });

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
        ]);
    }
}
