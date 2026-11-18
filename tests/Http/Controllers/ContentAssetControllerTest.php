<?php

it('redirects old content.spatie.be asset urls to its bucket', function () {
    $this->get('https://content.spatie.be/assets/flare/my post/thumbnail-(v2).jpg')
        ->assertRedirect('https://fls-a2e8a005-2380-4c8b-a69c-154d8efa1221.laravel.cloud/flare/my%20post/thumbnail-%28v2%29.jpg');
});

it('redirects old content.spatie.be glide urls to the original image', function () {
    $encodedPath = rtrim(base64_encode('assets/first-contact-resolution.png'), '=');

    $this->get("https://content.spatie.be/img/asset/{$encodedPath}/first-contact-resolution.png?w=1200")
        ->assertRedirect('https://fls-a2e8a005-2380-4c8b-a69c-154d8efa1221.laravel.cloud/first-contact-resolution.png');

    $this->get('https://content.spatie.be/img/asset/'.base64_encode('other/file.png').'/file.png')->assertNotFound();
});

it('does not serve spatie.be pages on content.spatie.be', function () {
    $this->get('https://content.spatie.be/')->assertNotFound();
    $this->get('https://content.spatie.be/blog')->assertNotFound();
});
