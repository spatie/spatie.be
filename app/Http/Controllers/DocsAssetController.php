<?php

namespace App\Http\Controllers;

use App\Docs\DocsStorage;
use App\Support\RepositoryAccess;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves images of the docs when they aren't served directly by the web server.
 * When the assets are in a bucket, the visitor is redirected to the bucket.
 */
class DocsAssetController
{
    public function __invoke(string $repository, string $alias, string $path, DocsStorage $docsStorage): StreamedResponse|RedirectResponse
    {
        $assetPath = "{$repository}/{$alias}/{$path}";

        if (in_array('..', explode('/', $assetPath), true)) {
            abort(404);
        }

        if (RepositoryAccess::isRestricted($repository)) {
            $privatePath = $docsStorage->currentReleasePath($repository) . "/{$alias}/{$path}";
            abort_unless($docsStorage->disk()->exists($privatePath), 404);

            return $docsStorage->disk()->response($privatePath, headers: ['Cache-Control' => 'private, no-store']);
        }

        if ($docsStorage->assetsAreInBucket()) {
            return redirect()->away($docsStorage->assetUrl($assetPath), 301, [
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        abort_unless($docsStorage->assetsDisk()->exists($assetPath), 404);

        return $docsStorage->assetsDisk()->response($assetPath, headers: [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
