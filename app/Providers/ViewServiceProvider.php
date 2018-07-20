<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('svg', function ($expression) {
            return "<?php echo svg({$expression}); ?>";
        });
    }
}
