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
        if ($this->isSpatieMember()) {
            return true;
        }

        return $this->is_sponsor;
    }

    public function isSpatieMember(): bool
    {
        if (!$this->github_username) {
            return false;
        }

        return Member::where('github', $this->github_username)->exists();
    }
}
