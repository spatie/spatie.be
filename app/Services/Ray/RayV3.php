<?php

namespace App\Services\Ray;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Yaml\Yaml;

class RayV3
{
    protected string $baseUrl = 'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/';

    public function getDownloadLink(string $platform): string
    {
        return Cache::remember(
            key: "ray-v3-download-{$platform}",
            ttl: now()->addMinutes(5),
            callback: fn () => match (strtolower($platform)) {
                'macos-arm64', 'macos' => $this->macOsArm64(),
                'macos-x64' => $this->macOsX64(),
                'windows' => $this->windows(),
                'linux' => $this->linux(),
            }
        );
    }

    public function macOsArm64(): string
    {
        return $this->getFilePathFromYml('latest-mac.yml', fn ($file) => str_contains($file['url'], 'arm64.dmg'));
    }

    public function macOsX64(): string
    {
        return $this->getFilePathFromYml('latest-mac.yml', fn ($file) => str_contains($file['url'], 'x64.dmg'));
    }

    public function linux(): string
    {
        return $this->getFilePathFromYml('latest-linux.yml');
    }

    public function windows(): string
    {
        return $this->getFilePathFromYml('latest.yml');
    }

    protected function getFilePathFromYml(string $file, ?callable $fileMatch = null): string
    {
        $body = Http::get("{$this->baseUrl}{$file}")->body();
        $releaseInfo = Yaml::parse($body);

        $file = collect($releaseInfo['files'])->first($fileMatch);

        return $this->baseUrl . $file['url'];
    }
}
