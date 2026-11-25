<?php

namespace Tests;

use App\Jobs\GeneratePackageGithubHeaderJob;
use App\Models\AdminAccess;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Queue;
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

        Queue::fake([GeneratePackageGithubHeaderJob::class]);
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
        ]);

        AdminAccess::create(['email' => strtolower($user->email), 'user_id' => $user->id]);

        $this->actingAs($user);

        return $user;
    }

    public function actingAsAdmin(): User
    {
        $user = $this->actingAsSpatie();

        AdminAccess::query()->where('email', strtolower($user->email))->update(['google_id' => 'test-google-id']);
        $this->withSession(['admin_google_login' => [
            'user_id' => $user->id,
            'email' => strtolower($user->email),
            'google_id' => 'test-google-id',
        ]]);

        return $user;
    }
}
