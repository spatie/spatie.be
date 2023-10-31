<?php

namespace Tests\Http;

it('loads the homepage', function () {
    $this
        ->get(route('home'))
        ->assertSuccessful();
});
