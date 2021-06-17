<?php

namespace Tests\Http\Middleware;

use App\Http\Middleware\AdminsOnly;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tests\TestCase;

class AdminsOnlyTest extends TestCase
{
    private AdminsOnly $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new AdminsOnly();
    }

    /** @test */
    public function it_will_pass_when_a_user_is_admin()
    {
        $request = new Request();

        $request->setUserResolver(
            fn () => User::factory()->make(['is_admin' => true])
        );

        $response = $this->middleware->handle($request, fn (Request $request) => $request);

        self::assertNotNull($response);
        self::assertInstanceOf(Request::class, $response);
    }

    /** @test */
    public function it_will_not_pass_when_no_user_is_logged_in()
    {
        $this->expectException(AuthenticationException::class);

        $request = new Request();

        $this->middleware->handle($request, fn (Request $request) => $request);
    }

    /** @test */
    public function it_will_not_pass_when_the_user_is_not_an_admin()
    {
        $this->expectException(AuthenticationException::class);

        $request = new Request();

        $request->setUserResolver(fn () => User::factory()->make(['is_admin' => false]));

        $this->middleware->handle($request, fn (Request $request) => $request);
    }
}
