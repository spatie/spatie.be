<?php

namespace App\Models;

use App\Services\Patreon\Resources\User;
use Illuminate\Database\Eloquent\Model;

class PatreonPledger extends Model
{
    public $dates = ['taken_at'];

    public static function import(User $user)
    {
        if (static::where('patreon_id', $user->id)->count() > 0) {
            return;
        }

        $model = new static();

        $model->patreon_id = $user->id;
        $model->name = $user->name;
        $model->avatar_url = $user->avatarUrl;

        $model->save();
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
