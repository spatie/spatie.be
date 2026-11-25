<?php

namespace App\Console\Commands;

use App\Models\AdminAccess;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GrantAdminAccessCommand extends Command
{
    protected $signature = 'admin:grant-access {email} {--user-id= : Link an independently verified existing customer account}';

    protected $description = 'Allow a Spatie address to sign in to the admin with Google';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $validator = Validator::make(['email' => $email, 'user_id' => $this->option('user-id')], [
            'email' => ['required', 'email', 'max:255', 'ends_with:@spatie.be'],
            'user_id' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }

        $user = null;

        if ($this->option('user-id') !== null) {
            $user = User::query()->whereKey($this->option('user-id'))->where('email', $email)->first();

            if (! $user) {
                $this->error('The user ID must belong to the verified account with this email address.');

                return self::FAILURE;
            }
        }

        $granted = DB::transaction(function () use ($email, $user): bool {
            $access = AdminAccess::query()->lockForUpdate()->firstOrCreate(['email' => $email]);

            if ($user) {
                if ($access->user_id !== null && $access->user_id !== $user->id) {
                    $this->error('This approval is already linked to another account. Remove the approval before replacing it.');

                    return false;
                }

                $access->update(['user_id' => $user->id]);
            }

            return true;
        });

        if (! $granted) {
            return self::FAILURE;
        }

        $this->info("{$email} can now sign in to the admin with Google.");

        return self::SUCCESS;
    }
}
