<?php

it('can render the homepage', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('advertises the existing LLM index and keeps HTML and Markdown representations separate', function () {
    foreach (['text/html', 'text/markdown', 'text/html'] as $accept) {
        $response = $this->get('/', ['Accept' => $accept])->assertOk()
            ->assertHeader('Link', '<'.url('/llms.txt').'>; rel="describedby"; type="text/plain"');

        expect($response->getVary())->toContain('Accept', 'User-Agent');
        $response->assertHeaderMissing('Content-Signal');

        if ($accept === 'text/html') {
            $response->assertHeader('Content-Type', 'text/html; charset=utf-8')
                ->assertSee('<h1', false);

            continue;
        }

        $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8')
            ->assertSee('Solid expertise', false)
            ->assertSee('Laravel &amp; AI', false)
            ->assertSee('We craft web applications', false)
            ->assertDontSee('<h1', false)
            ->assertDontSee('<script', false);
    }

    $this->get('/', ['User-Agent' => 'ClaudeBot'])->assertOk()
        ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8')
        ->assertHeader('Link', '<'.url('/llms.txt').'>; rel="describedby"; type="text/plain"');

    $this->get('/login', ['Accept' => 'text/markdown'])
        ->assertHeader('Content-Type', 'text/html; charset=utf-8');
    $this->get('/profile', ['Accept' => 'text/markdown'])->assertRedirect();
});
