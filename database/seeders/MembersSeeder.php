<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MembersSeeder extends Seeder
{
    protected $members = [
        'alex@spatie.be' => [
            'first_name' => 'Alex',
            'last_name' => 'Vanderbist',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'Alex can throw backend code, servers and hardware in the mix. He\'s famous for winning the first Laravel blog contest and struggling with Paypal ever since.',
            'twitter' => 'alexvanderbist',
            'website' => 'https://alexvanderbist.com',
            'website_rss' => 'https://alexvanderbist.com/feed',
            'birthday' => '1996-02-05',
        ],

        'freek@spatie.be' => [
            'first_name' => 'Freek',
            'last_name' => 'Van der Herten',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'Freek is our godfather of backend code. You are not into Laravel if this face doesn\'t ring a bell to you.',
            'twitter' => 'freekmurze',
            'website' => 'https://freek.dev',
            'website_rss' => 'https://freek.dev/feed/originals',
            'founder' => true,
            'birthday' => '1979-09-22',
        ],

        'jef@spatie.be' => [
            'first_name' => 'Jef',
            'last_name' => 'Van der Voort',
            'preferred_name' => null,
            'role' => 'Account manager',
            'description' => 'Jef keeps things going and basically runs the office. Who needs fancy applications when you can have a spreadsheet?',
            'twitter' => 'vdv_jef',
            'founder' => true,
            'public_email' => true,
            'birthday' => '1975-03-28',
        ],

        'niels@spatie.be' => [
            'first_name' => 'Niels',
            'last_name' => 'Vanpachtenbeke',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'The eleventh member of our team has solid experience in building modern web applications and API\'s. We have yet to find out what his scouting totem is… stay tuned!',
            'twitter' => 'NielsVanpach',
            'birthday' => '1993-07-14',
        ],

        'rias@spatie.be' => [
            'first_name' => 'Rias',
            'last_name' => 'Van der Veken',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'Another member of the Full Stack Antwerp family in our midst: Rias brings Laravel & CMS expertise to the backend table —with a smile.',
            'twitter' => 'riasvdv',
            'website' => 'https://rias.be',
            'website_rss' => 'https://rias.be/feed',
            'birthday' => '1992-05-25',
        ],

        'ruben@spatie.be' => [
            'first_name' => 'Ruben',
            'last_name' => 'Van Assche',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'Ruben knows how to write PHP. And C++. And Java. And Python. And he can talk to humans too!',
            'twitter' => 'rubenvanassche',
            'website' => 'https://rubenvanassche.com',
            'website_rss' => 'https://rubenvanassche.com/rss/',
            'birthday' => '1994-05-16',
        ],

        'sebastian@spatie.be' => [
            'first_name' => 'Sebastian',
            'last_name' => 'De Deyne',
            'preferred_name' => 'Seb',
            'role' => 'Full stack developer',
            'description' => 'Seb really earns the label ‘full stack’. Throw anything at this guy and he\'ll kick it back to you as a component.',
            'twitter' => 'sebdedeyne',
            'website' => 'https://sebastiandedeyne.com',
            'website_rss' => 'https://sebastiandedeyne.com/feed/articles',
            'birthday' => '1992-02-01',
        ],

        'wouter@spatie.be' => [
            'first_name' => 'Wouter',
            'last_name' => 'Brouwers',
            'preferred_name' => null,
            'role' => 'Project Manager',
            'description' => 'Who needs a status board when you have Wouter? This fellow knows a thing or 2 about closing Basecamp tickets.',
            'twitter' => 'brouwerswouter',
            'public_email' => true,
            'birthday' => '1991-03-15',
        ],

        'tim@spatie.be' => [
            'first_name' => 'Tim',
            'last_name' => 'Van Dijck',
            'preferred_name' => null,
            'role' => 'Full stack developer',
            'description' => 'Tim is the George Harrison of the team: quietly making essential contributions to all our major projects.',
            'twitter' => 'timvandijck',
            'website' => 'https://timvandijck.be',
            'birthday' => '1989-10-14',
        ],

    ];

    public function run(): void
    {
        foreach ($this->members as $email => $attributes) {
            Member::firstOrNew(['email' => $email])
                ->fill($attributes)
                ->save();
        }

        Member::whereNotIn('email', array_keys($this->members))
            ->delete();
    }
}
