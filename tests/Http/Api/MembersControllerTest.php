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
        ],
        [
            'first_name' => 'jef',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1975-03-28',
            'role' => 'Account manager',
            'description' => '',
            'email' => '',
        ],
        [
            'first_name' => 'freek',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1979-09-22',
            'role' => 'Backend developer',
            'description' => '',
            'email' => '',
        ],
        [
            'first_name' => 'sebastian',
            'last_name' => '',
            'preferred_name' => 'seb',
            'birthday' => '1979-09-22',
            'role' => 'Full stack developer',
            'description' => '',
            'email' => '',
        ],
    ];

    Member::insert($data);

    $this->get(action([MembersController::class, 'index']))
        ->assertStatus(200)
        ->assertExactJson([
                ['name' => 'Willem'],
                ['name' => 'Jef'],
                ['name' => 'Freek'],
                ['name' => 'Seb']]
        );
});
