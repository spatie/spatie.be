<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function it_can_render_the_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
