<?php

namespace App\Domain\Blog\Actions;

use App\Domain\Blog\Models\BlogPost;
use Dom\HTMLDocument;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PrepareBlogImagesAction
{
    public function execute(BlogPost $post): string
    {
        $document = HTMLDocument::createFromString('<!DOCTYPE html><html><body>'.$post->html.'</body></html>', LIBXML_NOERROR, 'UTF-8');
        $mediaByUrl = $post->media->keyBy(fn (Media $media) => $media->getUrl());

        foreach ($document->querySelectorAll('img') as $image) {
            $image->setAttribute('loading', 'lazy');
            $image->setAttribute('decoding', 'async');
            $media = $mediaByUrl->get($image->getAttribute('src'));

            if (! $media || ! $media->getCustomProperty('width')) {
                continue;
            }

            $image->setAttribute('width', (string) $media->getCustomProperty('width'));
            $image->setAttribute('height', (string) $media->getCustomProperty('height'));

            if ($srcset = $media->getSrcset()) {
                $image->setAttribute('srcset', $srcset);
                $image->setAttribute('sizes', '(min-width: 1024px) 800px, 100vw');
            }
        }

        return $document->querySelector('body')->innerHTML;
    }
}
