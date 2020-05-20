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


    public function isSponsoring(): bool
    {
        if ($this->isGitHubAccountOfSpatieMember()) {
            return true;
        }

        return $this->is_sponsor;
    }

    public function isGitHubAccountOfSpatieMember(): bool
    {
        return in_array($this->github_username, [
            'riasvdv',
            'freekmurze',
        ]);
    }
}
