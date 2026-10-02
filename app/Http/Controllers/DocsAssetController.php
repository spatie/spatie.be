<?php

namespace App\Http\Controllers;

use App\Docs\DocsStorage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves images of the docs when they aren't served directly by the web server,
 * for example when the assets disk is an object storage bucket.
 */
class DocsAssetController
{
    public function __invoke(string $repository, string $alias, string $path, DocsStorage $docsStorage): StreamedResponse
    {
        if (in_array('..', explode('/', $path), true)) {
            abort(404);
        }

        $assetPath = "{$repository}/{$alias}/{$path}";

        abort_unless($docsStorage->assetsDisk()->exists($assetPath), 404);

        return $docsStorage->assetsDisk()->response($assetPath, headers: [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
