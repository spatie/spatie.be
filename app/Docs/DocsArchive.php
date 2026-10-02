<?php

namespace App\Docs;

use App\Exceptions\DocsImportException;
use Generator;
use Illuminate\Support\Str;
use ZipArchive;

/**
 * A zipball of a GitHub repository. Its entries are prefixed with a single
 * root folder, e.g. `spatie-laravel-backup-1a2b3c4/docs/introduction.md`.
 */
class DocsArchive
{
    public function __construct(
        protected string $path,
    ) {
    }

    /**
     * Yields the contents of every file in the `docs` folder, keyed by its path
     * relative to that folder. Other files in the archive are never extracted.
     *
     * @return Generator<string, string>
     */
    public function docsFiles(): Generator
    {
        $zip = new ZipArchive();

        $result = $zip->open($this->path, ZipArchive::RDONLY);

        if ($result !== true) {
            throw new DocsImportException("Could not open archive `{$this->path}` (error {$result}).");
        }

        try {
            for ($index = 0; $index < $zip->numFiles; $index++) {
                $entryName = $zip->getNameIndex($index);

                $relativePath = $this->pathInsideDocsFolder($entryName);

                if ($relativePath === null) {
                    continue;
                }

                $contents = $zip->getFromIndex($index);

                if ($contents === false) {
                    throw new DocsImportException("Could not extract `{$entryName}` from archive `{$this->path}`.");
                }

                yield $relativePath => $contents;
            }
        } finally {
            $zip->close();
        }
    }

    protected function pathInsideDocsFolder(string|false $entryName): ?string
    {
        if ($entryName === false) {
            return null;
        }

        if (str_ends_with($entryName, '/')) {
            return null;
        }

        $pathWithoutRootFolder = Str::after($entryName, '/');

        if (! str_starts_with($pathWithoutRootFolder, 'docs/')) {
            return null;
        }

        $relativePath = Str::after($pathWithoutRootFolder, 'docs/');

        if (! $this->isSafePath($relativePath)) {
            return null;
        }

        return $relativePath;
    }

    protected function isSafePath(string $relativePath): bool
    {
        if ($relativePath === '') {
            return false;
        }

        if (str_starts_with($relativePath, '/')) {
            return false;
        }

        return ! in_array('..', explode('/', $relativePath), true);
    }
}
