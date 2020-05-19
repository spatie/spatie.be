<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sponsor()
    {
        return $this->hasOne(Sponsor::class, 'username', 'github_username');
    }

    public function getIsSponsorAttribute()
    {
        if (in_array($this->github_username, [
            'riasvdv',
        ])) {
            return true;
        }

        return !! $this->sponsor;
    }
}
