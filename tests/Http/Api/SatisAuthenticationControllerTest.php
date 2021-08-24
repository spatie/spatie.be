<?php

namespace Tests\Http\Api;

use App\Domain\Shop\Models\License;
use App\Http\Api\Controllers\SatisAuthenticationController;
use Tests\TestCase;

class SatisAuthenticationControllerTest extends TestCase
{
    /** @test * */
    public function it_will_abort_if_no_license_is_found()
    {
        $this->postJson(action(SatisAuthenticationController::class))->withHeaders([
            'authorization' => 'Bearer ' . 1,
        ])->assertStatus(401);
    }

    /** @test * */
    public function it_always_returns_valid_for_the_master_key()
    {
        config()->set('spatie.master_license_key', '12345');

        License::factory()->create([
            'key' => 12345,
            'expires_at' => now()->subHour(),
        ]);

        $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('username:12345'),
        ])->postJson(action(SatisAuthenticationController::class))
            ->assertStatus(200)
            ->assertSee('valid');
    }

    /** @test * */
    public function it_returns_401_if_a_package_isnt_found()
    {
        License::factory()->create([
            'key' => 12345,
            'expires_at' => now()->addHour(),
        ]);

        $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('username:12345'),
        ])->postJson(action(SatisAuthenticationController::class))
            ->assertStatus(401)
            ->assertSee('Missing X-Original-URI header');
    }

    /** @test * */
    public function it_returns_valid_for_a_valid_license()
    {
        $license = License::factory()->create([
            'key' => 12345,
            'expires_at' => now()->addHour(),
        ]);

        $license->assignment->purchasable->update([
            'satis_packages' => [
                'spatie/laravel-mailcoach',
            ]
        ]);

        $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('username:12345'),
            'X-Original-URI' => '/dist/spatie/laravel-mailcoach/spatie-laravel-mailcoach-xxx-zip-xx.zip',
        ])->postJson(action(SatisAuthenticationController::class))
            ->assertStatus(200)
            ->assertSee('valid');
    }
}
