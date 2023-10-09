<?php

namespace Tests\Http\Api;

use App\Http\Api\Controllers\MembersController;
use App\Models\Member;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all Spatie team members', function () {
    Sanctum::actingAs(User::factory()->create(['is_admin' => true]));

    Member::insert(membersDummyData());

    $this->get(action([MembersController::class, 'index']))
        ->assertStatus(200)
        ->assertExactJson(
            [
                ['name' => 'Jef', 'email' => 'je@spatie.be', 'birthday' => '1975-02-02','twitter' => 'vdv_jef', 'website' => null],
                ['name' => 'Freek', 'email' => 'fre@spatie.be', 'birthday' => '1979-03-03', 'twitter' => 'freekmurze', 'website' => 'https://freek.dev'],
                ['name' => 'Seb', 'email' => 'se@spatie.be', 'birthday' => '1979-04-04', 'twitter' => 'sebdedeyne', 'website' => 'https://sebastiandedeyne.com'],
            ]
        );
});

it('cannot fetch spatie data when unauthenticated', function () {
    $this->get(action([MembersController::class, 'index']))
        ->assertStatus(302);
});

it('cannot fetch spatie data when not authorized', function () {
    $this->actingAs(User::factory()->create());

    Member::insert(membersDummyData());

    $this->get(action([MembersController::class, 'index']))
        ->assertRedirect('login');
});

it('can perform an api call with the generated token', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $token = $user->createToken('api-token');

    Member::insert(membersDummyData());

    $this
        ->withToken($token->plainTextToken)
        ->get(action([MembersController::class, 'index']))
        ->assertStatus(200);
});

function membersDummyData(): array
{
    return [
        [
            'first_name' => 'jef',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1975-02-02',
            'role' => 'Account manager',
            'description' => '',
            'email' => 'je@spatie.be',
            'twitter' => 'vdv_jef',
            'website' => null,
        ],
        [
            'first_name' => 'freek',
            'last_name' => '',
            'preferred_name' => null,
            'birthday' => '1979-03-03',
            'role' => 'Backend developer',
            'description' => '',
            'email' => 'fre@spatie.be',
            'twitter' => 'freekmurze',
            'website' => 'https://freek.dev',
        ],
        [
            'first_name' => 'sebastian',
            'last_name' => '',
            'preferred_name' => 'seb',
            'birthday' => '1979-04-04',
            'role' => 'Full stack developer',
            'description' => '',
            'email' => 'se@spatie.be',
            'twitter' => 'sebdedeyne',
            'website' => 'https://sebastiandedeyne.com',
        ],
    ];
}
