<?php

namespace App\Support\Browsershot;

class Browsershot extends \Spatie\Browsershot\Browsershot
{
    public static function fake(): self
    {
        $instance = new BrowsershotFake();

        app()->instance(Browsershot::class, $instance);

        return $instance;
    }

    public static function unfake(): self
    {
        $instance = new self();

        app()->instance(Browsershot::class, $instance);

        return $instance;
    }
}
