<?php

it('loads livewire assets on filament pages', function () {
    $this->get(route('filament.admin.auth.login'))
        ->assertOk()
        ->assertSee('Livewire Styles', false)
        ->assertSee('Livewire Scripts', false)
        ->assertSee('data-update-uri', false);
});
