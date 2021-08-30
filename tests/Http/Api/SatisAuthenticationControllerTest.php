<?php

use App\Domain\Shop\Models\License;
use App\Http\Api\Controllers\SatisAuthenticationController;
use Tests\TestCase;



it('will abort if no license is found', function () {
    $this->markTestSkipped('To fix');

    $this->postJson(action(SatisAuthenticationController::class))->withHeaders([
        'authorization' => 'Bearer ' . 1,
    ])->assertStatus(401);
});

it('always returns valid for the master key', function () {
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
});

it('returns 401 if a package isnt found', function () {
    License::factory()->create([
        'key' => 12345,
        'expires_at' => now()->addHour(),
    ]);

    $this->withHeaders([
        'Authorization' => 'Basic ' . base64_encode('username:12345'),
    ])->postJson(action(SatisAuthenticationController::class))
        ->assertStatus(401)
        ->assertSee('Missing X-Original-URI header');
});

it('returns valid for a valid license', function () {
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
});
