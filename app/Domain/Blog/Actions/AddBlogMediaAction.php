<?php

namespace App\Domain\Blog\Actions;

use App\Domain\Blog\Models\BlogPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\File;

class AddBlogMediaAction
{
    public function execute(BlogPost $post, string|TemporaryUploadedFile $file, string $collection = 'attachments', array $properties = []): Media
    {
        if ($file instanceof TemporaryUploadedFile) {
            Validator::make(['file' => $file], ['file' => ['required', 'file', 'max:12288']])->validate();
            $temporary = tmpfile();
            $stream = $file->readStream();

            try {
                stream_copy_to_stream($stream, $temporary);

                return $this->execute($post, stream_get_meta_data($temporary)['uri'], $collection, $properties + ['original_name' => $file->getClientOriginalName()]);
            } finally {
                fclose($stream);
                fclose($temporary);
            }
        }

        $source = new File($file);
        Validator::make(['file' => $source], [
            'file' => ['required', 'file', 'max:30720', 'mimetypes:image/png,image/jpeg,image/gif,image/webp,image/avif,video/mp4,video/webm,application/pdf'],
        ])->validate();

        $dimensions = @getimagesize($file);

        return $post->addMedia($file)
            ->preservingOriginal()
            ->usingFileName(Str::uuid().'.'.$source->guessExtension())
            ->usingName(pathinfo($properties['original_name'] ?? basename($file), PATHINFO_FILENAME))
            ->withCustomProperties($properties + [
                'sha256' => hash_file('sha256', $file),
                'width' => $dimensions ? $dimensions[0] : null,
                'height' => $dimensions ? $dimensions[1] : null,
            ])
            ->withResponsiveImagesIf(in_array($source->getMimeType(), ['image/jpeg', 'image/png']))
            ->addCustomHeaders(['CacheControl' => 'public, max-age=31536000, immutable'])
            ->toMediaCollection($collection, 'medialibrary');
    }
}
