<?php


use Illuminate\Database\Seeder;
use Spatie\Mailcoach\Models\EmailList;

class EmailListSeeder extends Seeder
{
    public function run()
    {
        /** @var \Spatie\Mailcoach\Models\EmailList $emailList */
        $emailList = EmailList::create([
            'name' => 'Spatie',
            'requires_confirmation' => true,
            'default_from_email' => 'info@spatie.be',
            'default_from_name' => 'Spatie',
        ]);
    }
}
