<?php

namespace Tests\Docs\Support;

use ZipArchive;

class Zipball
{
    /**
     * Builds a zip in the format of a GitHub zipball, where every path
     * is prefixed with a single root folder.
     *
     * @param array<string, string> $files
     * @param string $rootFolder
     */
    public static function make(array $files, string $rootFolder = 'spatie-laravel-package-1a2b3c4'): string
    {
        $path = tempnam(sys_get_temp_dir(), 'zipball-fixture-');

        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::OVERWRITE);

        $zip->addEmptyDir($rootFolder);

        foreach ($files as $filePath => $contents) {
            $zip->addFromString("{$rootFolder}/{$filePath}", $contents);
        }

        $zip->close();

        $contents = file_get_contents($path);

        unlink($path);

        return $contents;
    }
}
