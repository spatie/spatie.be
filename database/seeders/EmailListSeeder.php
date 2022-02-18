<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;

class EmailListSeeder extends Seeder
{
    public function run(): void
    {
        $emailList = EmailList::create([
            'name' => 'Spatie',
            'requires_confirmation' => true,
            'default_from_email' => 'info@spatie.be',
            'default_from_name' => 'Spatie',
        ]);
    }
}
