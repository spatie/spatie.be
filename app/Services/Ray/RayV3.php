<?php

namespace App\Services\Ray;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RayV3
{
    protected string $baseUrl = 'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/beta';

    public function getDownloadLink(string $platform)
    {
        $method = "getDownloadLink" . ucfirst(strtolower($platform));

        return $this->$method();
    }

    public function getDownloadLinkMacOs(): string
    {
        $latestVersion = $this->latestVersion();

        return "{$this->baseUrl}/darwin/universal/Ray-darwin-universal-{$latestVersion}.zip";
    }

    public function getDownloadLinkWindows(): string
    {
        $latestVersion = $this->latestVersion();

        return "{$this->baseUrl}/win32/x64/Ray-{$latestVersion}%20Setup.exe";
    }

    public function getDownloadLinkLinux(): string
    {
        $latestVersion = $this->latestVersion();

        return "{$this->baseUrl}/linux/x64/ray_{$latestVersion}_amd64.deb";
    }

    public function latestVersion(): string
    {
        return Cache::remember('latest-mac-version-v3', 60, function () {
            $jsonPath = Http::get("{$this->baseUrl}/darwin/universal/RELEASES.json")->body();

            $versions = json_decode($jsonPath, true);

            $currentRelease = $versions['currentRelease'];

            return $currentRelease;
        });
    }
}
