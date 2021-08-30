<?php

use App\Models\Ad;
use App\Models\Repository;
use Tests\TestCase;



it('will redirect git hub ad clicks to the right url', function () {
    $redirectUrl = 'https://redirect.com';

    $repository = Repository::factory()->create([
        'ad_id' => Ad::factory()->create(['click_redirect_url' => $redirectUrl,]),
    ]);

    $repoName = urlencode($repository->name);

    $this
        ->get(route('github-ad-click', $repository->name))
        ->assertRedirect("$redirectUrl?utm_source=github&utm_medium=banner&utm_campaign=repo-{$repoName}");
});

it('will redirect invalid urls to the product page', function () {
    $this
        ->get(route('github-ad-click', 'invalid'))
        ->assertRedirect(route('products.index'));
});
