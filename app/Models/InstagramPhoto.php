<?php

namespace App\Models;

use \App\Services\Instagram\InstagramPhoto as Photo;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class InstagramPhoto extends Model implements HasMedia
{
    use HasMediaTrait;

    public $dates = ['taken_at'];

    public static function import(Photo $photo)
    {
        if (static::where('instagram_id', $photo->id())->first()) {
            return;
        }

        $model = new static();

        $model->instagram_id = $photo->id();
        $model->description = $photo->caption();
        $model->taken_at = $photo->createdTime();
        $model->url_to_original = $photo->link();
        $model
            ->addMediaFromUrl($photo->imageUrl())
            ->withResponsiveImages()
            ->toMediaCollection();

        $model->save();
    }

}
