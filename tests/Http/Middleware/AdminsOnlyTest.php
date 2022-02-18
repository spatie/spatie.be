<?php

use App\Http\Middleware\AdminsOnly;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->middleware = new AdminsOnly();
});

it('will pass when a user is admin', function () {
    $request = new Request();

    $request->setUserResolver(
        fn () => User::factory()->make(['is_admin' => true])
    );

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

    $request->setUserResolver(fn () => User::factory()->make(['is_admin' => false]));

    $this->middleware->handle($request, fn (Request $request) => $request);
});
