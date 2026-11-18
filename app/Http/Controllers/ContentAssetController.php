<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * The content.spatie.be CMS is gone, but its asset URLs are still linked from
 * old newsletters and shared posts. They are redirected to the files in its bucket.
 */
class ContentAssetController
{
    public function asset(string $path): RedirectResponse
    {
        return $this->redirectToBucket($path);
    }

    public function image(string $encodedPath): RedirectResponse
    {
        // Glide URLs encode "<container>/<path>". Without Glide, serve the original.
        $containerPath = base64_decode(strtr($encodedPath, '-_', '+/'), true);

        abort_unless(is_string($containerPath) && str_starts_with($containerPath, 'assets/'), 404);

        return $this->redirectToBucket(Str::after($containerPath, 'assets/'));
    }

    private function redirectToBucket(string $path): RedirectResponse
    {
        $segments = array_map(rawurlencode(...), explode('/', $path));

        return redirect()
            ->away(config('services.content_spatie_be.assets_url').'/'.implode('/', $segments))
            ->header('Cache-Control', 'public, max-age=3600, s-maxage=86400');
    }
}
