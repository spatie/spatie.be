<?php

use Tests\TestCase;

uses(TestCase::class);

it('can render the homepage', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
