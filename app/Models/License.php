<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class License extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $casts = [
        'expires_at' => 'datetime',
        'satis_authentication_count' => 'integer',
    ];

    public function isExpired(): bool
    {
        return optional($this->expires_at)->isPast() ?? false;
    }
}
