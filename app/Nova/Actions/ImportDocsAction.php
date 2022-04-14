<?php

namespace App\Nova\Actions;

use App\Console\Commands\ImportGitHubRepositoriesCommand;
use Artisan;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;

class ImportDocsAction extends Action
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
