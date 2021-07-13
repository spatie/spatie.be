<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Enums\ExperienceType;
use App\Models\User;
use Tests\TestCase;

class PullRequestTest extends TestCase
{
    /** @test */
    public function experience_is_earned_with_every_pull_request()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        command(RegisterPullRequest::forUser($user, 'pr'));

        $this->assertEquals(ExperienceType::PullRequest()->getAmount(), $user->experience->amount);
    }
}
