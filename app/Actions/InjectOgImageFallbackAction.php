<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Spatie\OgImage\Actions\InjectOgImageFallbackAction as BaseAction;
use Spatie\OgImage\OgImage;
use Spatie\OgImage\OgImageGenerator;

class InjectOgImageFallbackAction extends BaseAction
{
    public function execute(Request $request, string $content): ?string
    {
        $fallbackHtml = $this->renderFallback($request);

        if ($fallbackHtml === null) {
            return null;
        }

        $template = $this->buildTemplate($fallbackHtml);

        $result = $this->injectBeforeClosingTag($content, 'body', $template);

        // Only store in cache if the template was actually injected
        if ($result !== $content) {
            $ogImage = app(OgImage::class);
            $hash = $ogImage->hash($fallbackHtml);

            $ogImage->storeInCache($hash, app(OgImageGenerator::class)->resolveScreenshotUrl());
        }

        return $result;
    }

    protected function buildTemplate(string $fallbackHtml): string
    {
        $ogImage = app(OgImage::class);
        $hash = $ogImage->hash($fallbackHtml);
        $format = $ogImage->defaultFormat();

        return "<template data-og-image data-og-hash=\"{$hash}\" data-og-format=\"{$format}\">{$fallbackHtml}</template>";
    }

    protected function renderFallback(Request $request): ?string
    {
        $fallback = app(OgImageGenerator::class)->getFallbackUsing();

        if ($fallback === null) {
            return null;
        }

        $view = $fallback($request);

        if ($view === null) {
            return null;
        }

        return $view instanceof \Illuminate\View\View ? $view->render() : (string) $view;
    }
}
