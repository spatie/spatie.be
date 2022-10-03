<?php

namespace Tests\Http\Api;

use App\Http\Api\Controllers\MembersController;
use App\Models\Member;

it('returns all Spatie team members', function () {
    $data = [
        [
            'first_name' => 'willem',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1975-09-03',
            'role' => 'Frontend designer',
            'description' => '',
            'email' => '',
            'twitter' => 'willemvbockstal',
            'website' => null,
        ],
        [
            'first_name' => 'jef',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1975-03-28',
            'role' => 'Account manager',
            'description' => '',
            'email' => '',
            'twitter' => 'vdv_jef',
            'website' => null,
        ],
        [
            'first_name' => 'freek',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1979-09-22',
            'role' => 'Backend developer',
            'description' => '',
            'email' => '',
            'twitter' => 'freekmurze',
            'website' => 'https://freek.dev',
        ],
        [
            'first_name' => 'sebastian',
            'last_name' => '',
            'preferred_name' => 'seb',
            'birthday' => '1979-09-22',
            'role' => 'Full stack developer',
            'description' => '',
            'email' => '',
            'twitter' => 'sebdedeyne',
            'website' => 'https://sebastiandedeyne.com',
        ],
    ];

    Member::insert($data);

    $this->get(action([MembersController::class, 'index']))
        ->assertStatus(200)
        ->assertExactJson([
                ['name' => 'Willem', 'twitter' => 'willemvbockstal', 'website' => null],
                ['name' => 'Jef', 'twitter' => 'vdv_jef', 'website' => null],
                ['name' => 'Freek', 'twitter' => 'freekmurze', 'website' => 'https://freek.dev'],
                ['name' => 'Seb', 'twitter' => 'sebdedeyne', 'website' => 'https://sebastiandedeyne.com']
            ]
        );
});
