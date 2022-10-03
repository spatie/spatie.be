<?php

namespace Tests\Http\Api;

use App\Http\Api\Controllers\MembersController;

it('returns all Spatie team members', function () {
    $data = [
        [
            'name' => 'willem',
            'birthday' => '1975-09-03',
        ],
        [
            'name' => 'jef',
            'birthday' => '1975-03-28',
        ],
        [
            'name' => 'freek',
            'birthday' => '1979-09-22',
        ],
    ];

    config()->set('team.members', $data);

    $this->get(action([MembersController::class, 'index']))
        ->assertStatus(200)
        ->assertExactJson([
            ['name' => 'Willem'],
            ['name' => 'Jef'],
            ['name' => 'Freek']]
        );
});
