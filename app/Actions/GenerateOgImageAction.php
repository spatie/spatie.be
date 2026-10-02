<?php

namespace App\Actions;

use App\Jobs\GenerateOgImageJob;
use Illuminate\Support\Facades\Storage;
use Spatie\OgImage\Actions\GenerateOgImageAction as BaseGenerateOgImageAction;
use Spatie\OgImage\OgImage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Taking a screenshot is rate limited by Cloudflare Browser Run, so a missing
 * OG image is generated on the queue. Until it exists, visitors and crawlers
 * are sent to the default OG image instead of waiting for the screenshot.
 */
class GenerateOgImageAction extends BaseGenerateOgImageAction
{
    public const string FALLBACK_IMAGE = 'images/og-image.jpg';

    public function execute(string $filename): Response
    {
        $hash = pathinfo($filename, PATHINFO_FILENAME);
        $format = pathinfo($filename, PATHINFO_EXTENSION);

        if (! $hash || ! $format) {
            abort(404);
        }

        $ogImage = app(OgImage::class);
        $path = $ogImage->imagePath($hash, $format);
        $disk = Storage::disk(config('og-image.disk', 'public'));

        if ($disk->exists($path)) {
            return $this->serveImage($disk, $path, $format);
        }

        if (! $ogImage->getFromCache($hash)) {
            abort(404);
        }

        dispatch(new GenerateOgImageJob($hash, $format));

        return $this->redirectToFallbackImage();
    }

    protected function redirectToFallbackImage(): Response
    {
        return redirect(url(self::FALLBACK_IMAGE))->header('Cache-Control', 'no-store');
    }
}
