<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Image extends Model implements HasMedia
{
    use HasMediaTrait;

    public static function boot()
    {
        parent::boot();

        static::created(function (Image $image) {
            $image
                ->addMedia(resource_path($image->path))
                ->withResponsiveImages()
                ->preservingOriginal()
                ->toMediaCollection();
        });
    }

    public static function findByPath(string $path): ?Image
    {
        return static::wherePath($path)->first();
    }

    public static function createWithPath(string $path): Image
    {
        return static::create([
            'path' => static::normalizePath($path),
        ]);
    }

    public function scopeWherePath(Builder $builder, string $path): Builder
    {
        return $builder->where('path', static::normalizePath($path));
    }

    protected static function normalizePath(string $path): string
    {
        $resourcePath = 'images';

        $fullResourcePath = "resources/{$resourcePath}";

        $basePath = resource_path($resourcePath);

        return
            rtrim($resourcePath, '/')
            . '/'
            . ltrim(str_replace([$basePath, $fullResourcePath, $resourcePath], '', $path), '/');
    }
}
