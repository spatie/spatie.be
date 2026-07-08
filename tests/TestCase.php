<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Livewire\Livewire;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Livewire::flushState();

        $this->withoutVite();
        $this->withoutMix();
    }

    public function getStub(string $nameOfStub): string
    {
        return __DIR__ . "/stubs/{$nameOfStub}";
    }

    public function getJsonStubContent(string $nameOfStub): array
    {
        $path = $this->getStub($nameOfStub);

        return json_decode(file_get_contents($path), true);
    }

    public function actingAsSpatie(): User
    {
        $user = User::factory()->create([
            'github_username' => 'Nielsvanpach',
            'is_admin' => true,
        ]);

        $this->actingAs($user);

        return $user;
    }
}
