<?php

namespace Tests\Http;

it('loads the homepage', function () {
    $this
        ->get(route('home'))
        ->assertSuccessful()
        // This text is not present on the homepage due to black friday
        // TODO: enable again after black friday
//        ->assertSee('Solid expertise')
        ->assertSee('We craft web applications, software, courses')
        ->assertSee('Mailcoach Cloud')
    ;
});
