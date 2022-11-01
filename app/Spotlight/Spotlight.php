<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\SpotlightCommand;

class Spotlight extends \LivewireUI\Spotlight\Spotlight
{
    public static function registerInstantiatedCommand(SpotlightCommand $command)
    {
        self::$commands[] = $command;
    }
}
