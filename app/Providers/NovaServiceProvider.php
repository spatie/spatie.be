<?php

namespace App\Providers;

use App\Nova\Ad;
use App\Nova\Bundle;
use App\Nova\BundlePrice;
use App\Nova\Dashboards\Main;
use App\Nova\License;
use App\Nova\Playlist;
use App\Nova\Postcard;
use App\Nova\Product;
use App\Nova\Purchasable;
use App\Nova\PurchasablePrice;
use App\Nova\Purchase;
use App\Nova\Receipt;
use App\Nova\Release;
use App\Nova\Repository;
use App\Nova\Series;
use App\Nova\Technology;
use App\Nova\User;
use App\Nova\Video;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function () {
            return [

                MenuSection::make('Customers', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Purchase::class),
                    MenuItem::resource(License::class),
                    MenuItem::resource(Receipt::class),
                ])->icon('user'),

                MenuSection::make('Shop', [
                    MenuItem::resource(Product::class),
                    MenuItem::resource(Purchasable::class),
                    MenuItem::resource(PurchasablePrice::class),
                    MenuItem::resource(Bundle::class),
                    MenuItem::resource(BundlePrice::class),
                ])->icon('shopping-bag'),

                MenuSection::make('Videos', [
                    MenuItem::resource(Video::class),
                    MenuItem::resource(Series::class),
                ])->icon('eye'),

                MenuSection::make('Content', [
                    MenuItem::resource(Ad::class),
                    MenuItem::resource(Repository::class),
                    MenuItem::resource(Release::class),
                    MenuItem::resource(Postcard::class),
                    MenuItem::resource(Playlist::class),
                    MenuItem::resource(Technology::class),
                ])->icon('document-text'),
            ];
        });
    }

    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate(): void
    {
        Gate::define('viewNova', fn ($user) => $user->is_admin);
    }

    public function register()
    {
        Nova::style('admin', public_path('nova.css'));
    }

    protected function dashboards()
    {
        return [
            new Main(),
        ];
    }
}
