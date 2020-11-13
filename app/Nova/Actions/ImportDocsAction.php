<?php

namespace App\Nova\Actions;

use App\Console\Commands\ImportGitHubRepositoriesCommand;
use Artisan;
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class ImportDocsAction extends DetachedAction
{
    use InteractsWithQueue;
    use Queueable;

    public function label()
    {
        return 'Import docs';
    }

    public function handle()
    {
        dispatch(function () {
            Artisan::call(ImportGitHubRepositoriesCommand::class);
        });
    }
}
