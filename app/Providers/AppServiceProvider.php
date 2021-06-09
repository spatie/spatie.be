<?php

namespace App\Providers;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Model::unguard();

        Gate::define('viewMailcoach', function ($user = null) {
            return optional($user)->is_admin;
        });



        foreach (range(1, 5) as $i) {
            $command = new class($i) extends Command {
                public $signature = "dynamic-command";

                public function __construct($i)
                {
                    $this->signature = 'dynamic-command-' . $i;

                    parent::__construct();
                }
            };
        }

        $this->commands(get_class($command));

        Flash::levels([
            'success' => 'success',
            'error' => 'error',
        ]);
    }
}
