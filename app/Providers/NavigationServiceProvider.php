<?php

namespace App\Providers;

use Barryvdh\Debugbar\ServiceProvider;
use Spatie\Menu\Laravel\Menu;

class NavigationServiceProvider extends ServiceProvider
{
    public function register()
    {
        Menu::macro('main', function (array $properties = []) {
            return Menu::new()
                ->route('products.index', 'Products')
                ->route('open-source.packages', 'Open source')
                ->route('videos.index', 'Videos')
                ->route('web-development', 'Web development')

                ->setActiveFromRequest()
                ->addClass($properties['class'] ?? '');
        });

        Menu::macro('service', function (array $properties = []) {
            return Menu::new()
                ->route('about', 'About')
                ->route('docs', 'Docs')
                //->route('guidelines', 'Guidelines')

                ->withoutWrapperTag()
                ->withoutParentTag()
                ->setActiveClassOnLink()
                ->setActiveFromRequest();
        });

        Menu::macro('opensource', function () {
            return Menu::new()
                ->route('open-source.packages', 'Packages')
                ->route('open-source.projects', 'Projects')
                ->route('open-source.postcards', 'Postcard wall')
                ->route('open-source.support', 'Support us')
                ->setActiveFromRequest('/open-source')
                ->setActiveClass('submenu-active')
                ;
        });

        Menu::macro('profile', function () {
            return Menu::new()
                ->route('profile', 'Profile')
                ->route('profile.password', 'Password')
                ->route('purchases', 'Purchases')
                ->route('invoices', 'Invoices')
                ->setActiveFromRequest('/profile')
                ->setActiveClass('submenu-active')
                ;
        });
    }
}
