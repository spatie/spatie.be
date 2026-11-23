<?php

namespace App\Spotlight;

use App\Docs\Docs;
use LivewireUI\Spotlight\SpotlightCommand;

class Spotlight extends \LivewireUI\Spotlight\Spotlight
{
    public function boot(): void
    {
        self::$commands = array_values(array_filter(self::$commands, fn (SpotlightCommand $command) => ! $command instanceof DocsCommand));

        foreach (Docs::configurations()->sortBy('name') as $repository) {
            self::registerInstantiatedCommand(new DocsCommand($repository));
        }
    }

    public static function registerInstantiatedCommand(SpotlightCommand $command)
    {
        self::$commands[] = $command;
    }
}
