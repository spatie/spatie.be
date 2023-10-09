<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateApiTokenCommand extends Command
{
    protected $signature = 'generate:api-token {email}';

    public function handle(): void
    {
        $email = $this->argument('email');

        if (! is_string($email)) {
            $this->error('Email must be a string');

            return;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email is not valid');

            return;
        }

        /** @var User|null $user */
        $user = User::where('email', $email)->first();

        if ($user === null) {
            $this->error('User not found');

            return;
        }

        if (! $user->isSpatieMember()) {
            $this->error('User is not a Spatie member');

            return;
        }

        $token = $user->createToken('api-token');

        $this->info('API token generated');
        $this->info($token->plainTextToken);
    }
}
