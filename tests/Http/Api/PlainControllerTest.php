<?php

it('can display user info', function () {
    $this
        ->postJson(route('plain'), ['customer' => ['email' => 'freek@spatie.be']])
        ->assertSuccessful();
});
