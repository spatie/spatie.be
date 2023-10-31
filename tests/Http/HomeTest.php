<?php

namespace Tests\Http;

it('loads the homepage', function () {
    $this
        ->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Solid expertise')
        ->assertSee('We craft web applications, software, courses')
        ->assertSee('Mailcoach Cloud')
    ;
});
