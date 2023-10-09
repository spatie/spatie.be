<?php

namespace Http\Auth\Controllers;

use App\Http\Auth\Controllers\ApiTokensController;
use App\Models\Member;
use App\Models\User;

it('can create an api token for an admin', function () {
    $user = $this->actingAsSpatie();

    Member::factory()->create(['github' => $user->github_username]);

    $this
        ->post(action([ApiTokensController::class, 'refresh']))
        ->assertOk()
        ->assertJsonStructure(['token']);
});

it('cannot create an api token for non members', function () {
    $this->actingAsSpatie();

    $this
        ->post(action([ApiTokensController::class, 'refresh']))
        ->assertSee('You are not a Spatie member in file');
});

it('cannot create an api token for non admins', function () {
    $this->actingAs(User::factory()->create(['is_admin' => false]));

    $this
        ->post(action([ApiTokensController::class, 'refresh']))
        ->assertRedirect('login');
});

it('cannot create an api token for non authorized requests', function () {
    $this
        ->post(action([ApiTokensController::class, 'refresh']))
        ->assertRedirect('login');
});
