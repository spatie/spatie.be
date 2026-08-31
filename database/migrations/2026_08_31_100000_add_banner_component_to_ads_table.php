<?php

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class () extends Migration {
    protected array $ownAdPerRepository = [
        'laravel-medialibrary' => ['ad' => 'Media Library Pro', 'banner' => 'medialibrary'],
        'laravel-event-sourcing' => ['ad' => 'Event Sourcing in Laravel', 'banner' => 'event-sourcing'],
    ];

    public function up()
    {
        if (! Schema::hasColumn('ads', 'banner_component')) {
            Schema::table('ads', function (Blueprint $table) {
                $table->string('banner_component')->nullable();
            });
        }

        $this->linkAdsNamedAfterTheirBanner();

        foreach ($this->ownAdPerRepository as $repositoryName => $own) {
            $this->pinRepositoryToItsOwnAd($repositoryName, $own['ad'], $own['banner']);
        }
    }

    protected function linkAdsNamedAfterTheirBanner(): void
    {
        Ad::query()->each(function (Ad $ad) {
            $banner = Str::slug($ad->name);

            if (! view()->exists("components.banners.{$banner}")) {
                return;
            }

            $ad->update(['banner_component' => $banner]);
        });
    }

    protected function pinRepositoryToItsOwnAd(string $repositoryName, string $adName, string $banner): void
    {
        $repository = Repository::query()->where('name', $repositoryName)->first();
        $ad = Ad::query()->where('name', $adName)->first();

        if (! $repository || ! $ad) {
            return;
        }

        $ad->update(['banner_component' => $banner, 'active' => true]);

        $repository->update(['ad_id' => $ad->id, 'ad_should_be_randomized' => false]);
    }
};
