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
                ->setActiveFromRequest()
                ->addClass($properties['class'] ?? '')
                ->route('home', 'Home')
                ->route('web-development', 'Web development')
                ->route('laravel', 'Laravel')
                ->route('open-source.index', 'Open source')
                ->route('about', 'About us');
        });

        Menu::macro('opensource', function () {
            //TO DO: add `<i class="far fa-angle-right ml-2 opacity-50"></i>` after active item

            return Menu::new()
                ->setActiveFromRequest('/open-source')
                ->setActiveClass('font-bold')
                ->addClass('text-xl leading-loose links-underline links-white')
                ->route('open-source.index', 'Overview')
                ->route('open-source.packages', 'Packages')
                ->route('open-source.projects', 'Projects')
                ->route('open-source.postcards', 'Postcard wall');
        });
    }
}
