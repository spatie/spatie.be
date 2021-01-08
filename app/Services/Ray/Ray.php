<?php

namespace App\Services\Ray;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Yaml\Yaml;

class Ray
{
    protected $baseUrl = 'https://ray-app.s3.eu-west-1.amazonaws.com';

    public function getDownloadLink(string $platform)
    {
        $method = "getDownloadLink" . ucfirst(strtolower($platform));

        return $this->$method();
    }

    public function latestMacosVersion(): string
    {
        return Cache::remember('latest-mac-version', 60, function () {
            $yaml = Http::get("{$this->baseUrl}/latest-mac.yml")->body();

            return Yaml::parse($yaml)['version'];
        });
    }

    public function getDownloadLinkMacos(): string
    {
        $latestVersion = $this->latestMacosVersion();

        return "{$this->baseUrl}/Ray-{$latestVersion}.dmg";
    }

    public function latestWindowsVersion(): string
    {
        return Cache::remember('latest-windows-version', 60, function () {
            $yaml = Http::get("{$this->baseUrl}/latest.yml")->body();

            return Yaml::parse($yaml)['version'];
        });
    }

    public function getDownloadLinkWindows(): string
    {
        $latestVersion = $this->latestWindowsVersion();

        return "{$this->baseUrl}/Ray Setup {$latestVersion}.exe";
    }

    public function latestLinuxVersion(): string
    {
        return Cache::remember('latest-linux-version', 60, function () {
            $yaml = Http::get("{$this->baseUrl}/latest.yml")->body();

            return Yaml::parse($yaml)['version'];
        });
    }

    public function getDownloadLinkLinux(): string
    {
        $latestVersion = $this->latestLinuxVersion();

        return "{$this->baseUrl}Ray-{$latestVersion}.AppImage";
    }
}
