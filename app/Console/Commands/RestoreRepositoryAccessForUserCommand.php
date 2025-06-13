<?php

namespace App\Console\Commands;

use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use App\Models\User;
use Illuminate\Console\Command;

class RestoreRepositoryAccessForUserCommand extends Command
{
    protected $signature = 'app:restore-repository-access-for-user-command {userId}';

    protected $description = 'Command description';

    public function handle()
    {
        $user = User::findOrFail($this->argument('userId'));
        app(RestoreRepositoryAccessAction::class)->execute($user);
    }
}
