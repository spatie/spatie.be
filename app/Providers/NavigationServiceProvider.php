<?php

namespace App\Providers;

use Barryvdh\Debugbar\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\View;

class NavigationServiceProvider extends ServiceProvider
{
    public function register()
    {
        Menu::macro('main', function (array $properties = []) {
            return Menu::new()
                ->route('products.index', 'Products')
                ->route('open-source.packages', 'Open Source')
                ->route('videos.index', 'Videos')
                ->route('web-development', 'Web Development')

                ->setActiveFromRequest()
                ->addClass($properties['class'] ?? '');
        });

        Menu::macro('service', function (array $properties = []) {
            return Menu::new()
                ->route('about', 'About')
                ->route('docs', 'Docs')
                ->route('guidelines', 'Guidelines')
                ->addIf(auth()->check(), View::create('layout.partials.navigation.profileIcon', ['url' => route('profile')]))
                ->addIf(! auth()->check(), View::create('layout.partials.navigation.loginIcon', ['url' => route('login')]))

                ->withoutWrapperTag()
                ->withoutParentTag()
                ->setActiveClassOnLink()
                ->setActiveFromRequest();
        });

        Menu::macro('opensource', function () {
            return Menu::new()
                ->route('open-source.packages', 'Packages')
                ->route('open-source.projects', 'Projects')
                ->route('open-source.postcards', 'Postcard Wall')
                ->route('open-source.support', 'Support Us')
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
