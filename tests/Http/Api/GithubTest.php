<?php

namespace Tests\Http\Api;

use Tests\TestCase;

class GithubTest extends TestCase
{
    /** @test */
    public function it_can_receive_a_webhook()
    {
        $data = [
            "repository" => [
                "full_name" => "laravel-medialibrary",
            ],
        ];

        $this->post('api/webhooks/github', $data)
            ->assertStatus(200)
        ;
    }
}
