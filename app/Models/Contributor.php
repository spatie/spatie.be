<?php

namespace App\Models;

class Contributor extends Model
{
    public function getStyledUsernameAttribute(): string
    {
        return '@' . $this->username;
    }
}
