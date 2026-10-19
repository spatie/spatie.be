<?php

use Illuminate\Support\Facades\Storage;
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

/**
 * Point a disk to a directory of the public bucket, like it is on Laravel Cloud.
 */
function storeDiskInPublicBucket(string $diskName, string $prefix): void
{
    config()->set('filesystems.disks.cloud-public', [
        'driver' => 's3',
        'key' => 'key',
        'secret' => 'secret',
        'region' => 'auto',
        'bucket' => 'public-bucket',
        'url' => 'https://public-bucket.example.com',
        'endpoint' => 'https://storage.example.com',
    ]);

    config()->set("filesystems.disks.{$diskName}", [
        'driver' => 'scoped',
        'disk' => 'cloud-public',
        'prefix' => $prefix,
        'visibility' => 'public',
    ]);

    Storage::forgetDisk(['cloud-public', $diskName]);
}
