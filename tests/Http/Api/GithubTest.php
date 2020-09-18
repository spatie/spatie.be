<?php

namespace Tests\Http\Api;

use Tests\TestCase;

class GithubTest extends TestCase
{
    /** @test */
    public function it_can_receive_a_webhook(): void
    {
        $data = [
            "repository" => [
                "full_name" => "laravel-medialibrary",
            ],
        ];

        $response = $this->post('api/webhooks/github', $data);

        $response->assertStatus(200);
    }
}
