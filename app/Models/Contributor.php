<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contributor extends Model
{
    use HasFactory;

    public function getStyledUsernameAttribute(): string
    {
        return '@' . $this->username;
    }
}
