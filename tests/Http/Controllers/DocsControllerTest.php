<?php

namespace Http\Controllers;

it('can load the docs', function () {
    $this
        ->get(route('docs'))
        ->assertOk()
        ->assertSee('lighthouse-php')
        ->assertSee('laravel-comments')
        ->assertSee('laravel-backup')
        ->assertSee('laravel-data')
    ;
});
