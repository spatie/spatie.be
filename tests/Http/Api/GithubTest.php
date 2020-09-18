<?php

namespace Tests\Http\Webhooks;

use Tests\TestCase;

class GithubTest extends TestCase
{
    /** @test */
    public function it_can_receive_a_webhook(): void
    {
        $data = [];
        $response = $this->post('/webhooks/github', $data);

        dd($response->content());
        $response->assertStatus(200);
    }
}
