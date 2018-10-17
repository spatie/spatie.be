<?php

namespace App\Models;

use App\Services\Patreon\Resources\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class PatreonPledger extends Model implements HasMedia
{
    use HasMediaTrait;

    public $dates = ['taken_at'];

    public static function import(User $user)
    {
        if (static::where('patreon_id', $user->id)->count() > 0) {
            return;
        }

        $model = new static();

        $model->patreon_id = $user->id;
        $model->name = $user->name;
        $model->url_to_original = $user->imageUrl;
        $model
            ->addMediaFromUrl($user->imageUrl)
            ->withResponsiveImages()
            ->toMediaCollection();

        $model->save();
    }

    public function getAvatarUrlAttribute()
    {
        return $this->getFirstMediaUrl();
    }

    public function getRespectPhraseAttribute()
    {
        return collect([
            "Thank your for your pledge",
            "You sir/madam are awesome",
            "We eat our monthly pasta thanks to you",
            "Your actions are heart-warming",
        ])->random();
    }
}
