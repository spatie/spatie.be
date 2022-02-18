<?php




it('can render the homepage', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
