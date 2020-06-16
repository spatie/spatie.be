<?php

use App\Models\License;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        collect([
            'freek',
            'willem',
            'rias',
            'alex',
        ])->each(fn (string $name) => User::create([
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]));
    }
}
