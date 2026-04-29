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
            'twitter' => 'alex_',
            'website' => 'https://alexvanderbist.com',
            'website_rss' => 'https://alexvanderbist.com/feed',
            'birthday' => '1996-02-05',
        ],

        'dries@spatie.be' => [
            'first_name' => 'Dries',
            'last_name' => 'Heyninck',
            'preferred_name' => null,
            'role' => 'Frontend developer',
            'description' => 'Dries brings competitive sprinter energy to frontend development - fast, focused, and always optimizing for performance.',
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

        'jimi@spatie.be' => [
            'first_name' => 'Jimi',
            'last_name' => 'Robaer',
            'preferred_name' => null,
            'role' => 'Designer',
            'description' => 'Everyone is a designer until you have a designer on your team. Has been building things on the web since before Flexbox was invented.',
            'twitter' => 'jimirobaer',
            'website' => 'https://jimirobaer.be',
        ],

        'marceli@spatie.be' => [
            'first_name' => 'Marceli',
            'last_name' => 'Wilczynski',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'Marceli is the backend wizard who turns "it can\'t be done" into "it\'s already deployed."',
        ],

        'nickb@spatie.be' => [
            'first_name' => 'Nick',
            'last_name' => 'Bevers',
            'preferred_name' => null,
            'role' => 'Frontend developer',
            'description' => 'Nick bakes the greatest cookies. Both in the browser and in real life.',
            'website' => 'https://nickbevers.dev',
        ],

        'nickd@spatie.be' => [
            'first_name' => 'Nick',
            'last_name' => 'Denys',
            'preferred_name' => null,
            'role' => 'Backend developer',
            'description' => 'Nick builds things that work as well as they look. He won\'t ship it until both the code and the pixels are right.',
            'website' => 'https://nickdenys.com',
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
            'description' => 'Seb really earns the label \'full stack\'. Throw anything at this guy and he\'ll kick it back to you as a component.',
            'twitter' => 'sebdedeyne',
            'website' => 'https://sebastiandedeyne.com',
            'website_rss' => 'https://sebastiandedeyne.com/feed/articles',
            'birthday' => '1992-02-01',
        ],

        'sebastien@spatie.be' => [
            'first_name' => 'Sébastien',
            'last_name' => 'Henau',
            'preferred_name' => 'Seba',
            'role' => 'Frontend developer',
            'description' => 'Seba is our master of JavaScript and frontend technologies. He can make browsers sing, dance, and jump through flamings hoops.',
            'website' => 'https://sebastienhenau.com',
        ],

        'tim@spatie.be' => [
            'first_name' => 'Tim',
            'last_name' => 'Van Dijck',
            'preferred_name' => null,
            'role' => 'Full stack developer',
            'description' => 'Tim is the George Harrison of the team: quietly making essential contributions to all our major projects.',
            'twitter' => 'timvandijck',
            'website' => 'https://veedee.dev',
            'birthday' => '1989-10-14',
        ],

        'zuzana@spatie.be' => [
            'first_name' => 'Zuzana',
            'last_name' => 'Kunckova',
            'preferred_name' => null,
            'role' => 'Support engineer',
            'description' => 'Zuzana has the rare ability of turning support questions into high-fives.',
            'twitter' => 'zuzana_kunckova',
            'website' => 'https://www.zuzana-k.com',
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
