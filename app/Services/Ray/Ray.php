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

    public function latestMacosIntelVersion(): string
    {
        return Cache::remember('latest-mac-version', 60, function () {
            $yaml = Http::get("{$this->baseUrl}/latest-mac.yml")->body();

            return Yaml::parse($yaml)['version'];
        });
    }

    public function getDownloadLinkMacosIntel(): string
    {
        $latestVersion = $this->latestMacosIntelVersion();

        return "{$this->baseUrl}/Ray-{$latestVersion}.dmg";
    }

    public function latestMacosAppleSiliconVersion(): string
    {
        /** Hardcoded for now, replace when building new version */
        return '1.19.0';

        /**return Cache::remember('latest-mac-version', 60, function () {
            $yaml = Http::get("{$this->baseUrl}/arm64/latest-mac.yml")->body();

            return Yaml::parse($yaml)['version'];
        });*/
    }

    public function getDownloadLinkMacosAppleSilicon(): string
    {
        /** Hardcoded for now, replace when building new version */
        return 'https://ray-app.s3.eu-west-1.amazonaws.com/arm64/Ray-1.19.0-arm64.dmg';

        $latestVersion = $this->latestMacosAppleSiliconVersion();

        return "{$this->baseUrl}/arm64/Ray-{$latestVersion}-arm64.dmg";
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

        return "{$this->baseUrl}/Ray-{$latestVersion}.AppImage";
    }
}
