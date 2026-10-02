<?php

use Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/**
 * Evaluate a config file as if the given environment variables were set.
 *
 * @param  array<string, string>  $environmentVariables
 * @return array<string, mixed>
 */
function configWithEnvironment(string $configFile, array $environmentVariables): array
{
    foreach ($environmentVariables as $name => $value) {
        putenv("{$name}={$value}");
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }

    try {
        return require config_path($configFile);
    } finally {
        foreach (array_keys($environmentVariables) as $name) {
            putenv($name);
            unset($_ENV[$name], $_SERVER[$name]);
        }
    }
}
