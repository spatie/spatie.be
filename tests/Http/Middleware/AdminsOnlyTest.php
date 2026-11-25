<?php

use App\Http\Middleware\AdminsOnly;
use App\Models\AdminAccess;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->middleware = new AdminsOnly();
});

it('will pass when a user is admin', function () {
    $user = User::factory()->create();
    AdminAccess::create(['email' => strtolower($user->email), 'user_id' => $user->id]);

    $request = new Request();

    $request->setUserResolver(fn () => $user);

    $response = $this->middleware->handle($request, fn (Request $request) => $request);

    self::assertNotNull($response);
    expect($response)->toBeInstanceOf(Request::class);
});

it('will not pass when no user is logged in', function () {
    $this->expectException(AuthenticationException::class);

    $request = new Request();

    $this->middleware->handle($request, fn (Request $request) => $request);
});

it('will not pass when the user is not an admin', function () {
    $this->expectException(AuthenticationException::class);

    $request = new Request();

    $request->setUserResolver(fn () => User::factory()->create());

    $this->middleware->handle($request, fn (Request $request) => $request);
});
