<?php

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('github_ads');
});

it('offers every banner component as an option, except the random one', function () {
    $components = Ad::availableBannerComponents();

    expect($components)
        ->toHaveKey('flare')
        ->toHaveKey('mailcoach')
        ->not->toHaveKey('randomBanner');
});

it('returns the banner configured on the ad', function () {
    $ad = Ad::factory()->active()->create(['banner_component' => 'flare']);

    expect($ad->bannerView())->toBe('components.banners.flare');
});

it('returns no banner when the ad has none configured', function () {
    $ad = Ad::factory()->active()->create(['banner_component' => null]);

    expect($ad->bannerView())->toBeNull();
});

it('returns no banner when the configured component no longer exists', function () {
    $ad = Ad::factory()->active()->create(['banner_component' => 'removed-banner']);

    expect($ad->bannerView())->toBeNull();
});

it('returns no banner when the ad is inactive', function () {
    $ad = Ad::factory()->inactive()->create(['banner_component' => 'flare']);

    expect($ad->bannerView())->toBeNull();
});

it('exposes the banner of the ad associated with a repository', function () {
    $ad = Ad::factory()->active()->create(['banner_component' => 'flare']);
    $repository = Repository::factory()->create(['ad_id' => $ad->id]);

    expect($repository->adBannerView())->toBe('components.banners.flare');
});

it('exposes no banner for a repository without an ad', function () {
    $repository = Repository::factory()->create(['ad_id' => null]);

    expect($repository->adBannerView())->toBeNull();
});

it('always renders the ad of the repository instead of a random banner', function () {
    $ad = Ad::factory()->active()->create(['banner_component' => 'flare']);
    $repository = Repository::factory()->create(['ad_id' => $ad->id]);

    foreach (range(1, 20) as $ignored) {
        $rendered = renderRandomBanner(['repositoryModel' => $repository->fresh()]);

        expect($rendered)->toContain('flareapp.io');
    }
});

it('falls back to a random banner when the repository has no ad', function () {
    $repository = Repository::factory()->create(['ad_id' => null]);

    $rendered = renderRandomBanner(['repositoryModel' => $repository]);

    expect($rendered)->toContain('?ref=spatie-docs');
});

it('renders a random banner when no repository is given', function () {
    $rendered = renderRandomBanner();

    expect($rendered)->toContain('?ref=spatie-docs');
});

it('passes the props it is rendered with through to the banner', function () {
    $rendered = renderRandomBanner(['ref' => 'posts', 'class' => 'my-6', 'thin' => true]);

    expect($rendered)
        ->toContain('?ref=posts')
        ->toContain('my-6');
});

function renderRandomBanner(array $data = []): string
{
    return Blade::render('@include("components.banners.randomBanner")', $data);
}
