<?php

namespace App\Providers;

use Barryvdh\Debugbar\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\View;

class NavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Menu::macro('main', function (array $properties = []) {
            return Menu::new()
                ->route('products.index', 'Products')
                ->route('open-source.index', 'Open Source')
                ->route('courses.index', 'Courses')
                ->route('web-development', 'Web Development')

                ->setActiveFromRequest()
                ->addClass($properties['class'] ?? '');
        });

        Menu::macro('service', function (array $properties = []) {
            return Menu::new()
                ->addItemClass('first:-m-1 first:p-1 rounded-sm')
                // ->route('vacancies.index', 'Vacancies')
                ->route('about', 'About')
                ->route('blog', 'Blog')
                // ->route('insights', 'Insights')
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

        Menu::macro('blog', function () {
            return Menu::new()
                ->route('blog', 'Latest Insights')
                ->route('music', 'Corporate Melodies')
                ->setActiveFromRequest('/blog')
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
