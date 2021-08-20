<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

return new class extends Migration
{
    public function up()
    {
        Media::each(function (Media $media) {
            switch($media->model_type) {
                case 'App\Models\Product':
                    $media->update(['model_type' => \App\Domain\Shop\Models\Product::class]);
                    break;
                case 'App\Models\Bundle':
                    $media->update(['model_type' => \App\Domain\Shop\Models\Bundle::class]);
                    break;
                case 'App\Models\Purchasable':
                    $media->update(['model_type' => \App\Domain\Shop\Models\Purchasable::class]);
                    break;
            }
        });
    }
};
