<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sponsor()
    {
        return $this->hasOne(Sponsor::class, 'username', 'github_username');
    }

    public function getIsSponsorAttribute(): bool
    {
        if ($this->isGitHubAccountOfSpatieMember()) {
            return true;
        }

        return (bool)$this->sponsor;
    }

    public function isGitHubAccountOfSpatieMember(): bool
    {
        return in_array($this->github_username, [
            'riasvdv',
            'freekmurze',
        ]);
    }
}
