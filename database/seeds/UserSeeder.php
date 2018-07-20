<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'basic auth user',
            'email' => env('BASIC_AUTH_USERNAME'),
            'password' => bcrypt(env('BASIC_AUTH_PASSWORD')),
        ]);
    }
}
