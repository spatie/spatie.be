<?php

it('renders meta tags with a title attribute and description slot', function () {
    $this
        ->get(route('legal.index'))
        ->assertOk()
        ->assertSee('<title>Legal | Spatie</title>', false)
        ->assertSee('<meta name="description" content="General conditions, policies & disclaimers. A lot of difficult sentences.">', false)
        ->assertSee('<meta property="og:title" content="Legal"/>', false)
        ->assertSee('<meta property="og:description" content="General conditions, policies & disclaimers. A lot of difficult sentences."/>', false);
});

it('renders meta tags with a title attribute and description attribute', function () {
    $this
        ->get(route('legal.privacy'))
        ->assertOk()
        ->assertSee('<title>Privacy | Spatie</title>', false)
        ->assertSee('<meta name="description" content="Our privacy policy. Because we respect you.">', false)
        ->assertSee('<meta property="og:title" content="Privacy"/>', false)
        ->assertSee('<meta property="og:description" content="Our privacy policy. Because we respect you."/>', false);
});
