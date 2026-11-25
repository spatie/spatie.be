<?php

namespace App\Console\Commands;

use App\Models\AdminAccess;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class GrantAdminAccessCommand extends Command
{
    protected $signature = 'admin:grant-access {email}';

    protected $description = 'Allow a Spatie address to sign in to the admin with Google';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email', 'max:255', 'ends_with:@spatie.be'],
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }

        AdminAccess::firstOrCreate(['email' => $email]);

        $this->info("{$email} can now sign in to the admin with Google.");

        return self::SUCCESS;
    }
}
