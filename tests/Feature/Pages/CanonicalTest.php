<?php

it('renders a self-referencing canonical with the clean url', function () {
    $this->get('/?utm_source=newsletter')
        ->assertStatus(200)
        ->assertSee('<link rel="canonical" href="'.url('/').'" />', false);
});
