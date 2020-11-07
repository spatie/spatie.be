<?php

namespace Tests\Feature\GitHubAds;

use App\Models\Ad;
use App\Models\Repository;
use Tests\TestCase;

class RedirectGitHubAdClickControllerTest extends TestCase
{
    /** @test **/
    public function it_will_redirect_GitHub_ad_clicks_to_the_right_url()
    {
        $redirectUrl = 'https://redirect.com';

        $repository = Repository::factory()->create([
            'ad_id' => Ad::factory()->create(['click_redirect_url' => $redirectUrl,]),
        ]);

        $repoName = urlencode($repository->name);

        $this
            ->get(route('github-ad-click', $repository->name))
            ->assertRedirect("$redirectUrl?utm_source=github&utm_medium=banner&utm_campaign=repo-{$repoName}");
    }

    /** @test */
    public function it_will_redirect_invalid_urls_to_the_product_page()
    {
        $this
            ->get(route('github-ad-click', 'invalid'))
            ->assertRedirect(route('products.index'));
    }
}
