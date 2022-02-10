<?php

namespace Tests\Http\Auth\Controllers;

use App\Http\Auth\Controllers\LoginController;
use App\Models\User;

it('can show a login form to an anonymous user', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(action([LoginController::class, 'showLoginForm']));

    $response
        ->assertOk()
        ->assertSessionHas('next', route('products.index'));
});

it('redirects a registered user', function () {
    $user = User::factory()->make();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this
        ->actingAs($user)
        ->get(action([LoginController::class, 'showLoginForm']));

    $response->assertRedirect(route('profile'));
});

it('can store a redirect url to a spatie domain', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this
        ->get(action([LoginController::class, 'showLoginForm'], ['next' => 'https://spatie.be.test/redirect']));

    $response
        ->assertOk()
        ->assertSessionHas('next', 'https://spatie.be.test/redirect');
});

it('cannot store a redirect url to an external domain', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this
        ->get(action([LoginController::class, 'showLoginForm'], ['next' => 'https://external.com/redirect']));

    $response
        ->assertOk()
        ->assertSessionHas('next', route('products.index'));
});
