<?php

namespace App\Services\Ray;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;
use SimpleXMLElement;

class RayV4
{
    protected const SparkleNamespace = 'http://www.andymatuschak.org/xml-namespaces/sparkle';

    protected string $baseUrl = 'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v4';

    protected string $channel = 'stable';

    public function getDownloadLink(string $platform): string
    {
        return Cache::remember(
            key: "ray-v4-download-{$platform}",
            ttl: now()->addMinutes(5),
            callback: fn () => match ($platform) {
                'macos', 'macos-arm64', 'macos-x64' => $this->macOs(),
                'windows' => "{$this->baseUrl}/velopack/Ray-win-{$this->channel}-Setup.exe",
                'linux' => "{$this->baseUrl}/velopack/Ray-linux-{$this->channel}.AppImage",
                default => throw new InvalidArgumentException("Unknown Ray platform `{$platform}`"),
            },
        );
    }

    protected function macOs(): string
    {
        $appcast = new SimpleXMLElement(Http::get("{$this->baseUrl}/mac/appcast.xml")->throw()->body());
        $appcast->registerXPathNamespace('sparkle', self::SparkleNamespace);

        // Stable items have no <sparkle:channel>.
        $latestRelease = collect($appcast->xpath('//item[not(sparkle:channel)]'))
            ->map(fn (SimpleXMLElement $item) => $item->children(self::SparkleNamespace))
            ->sortByDesc(fn (SimpleXMLElement $release) => (int) $release->version)
            ->first();

        if (! $latestRelease) {
            throw new RuntimeException('The Ray appcast has no stable release');
        }

        return "{$this->baseUrl}/mac/{$this->channel}/ray-{$latestRelease->shortVersionString}-{$this->channel}-mac-universal.dmg";
    }
}
