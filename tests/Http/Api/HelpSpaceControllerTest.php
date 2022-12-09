<?php

it('can display user info', function () {
    $this
        ->withoutMiddleware()
        ->postJson(route('helpSpace'), ['from_contact' => ['value' => 'freek@spatie.be']])
        ->assertSuccessful();
});

it('will return forbidden for a non-signed HelpSpace request', function() {
    $this
        ->postJson(route('helpSpace'), ['from_contact' => ['value' => 'freek@spatie.be']])
        ->assertForbidden();
});
