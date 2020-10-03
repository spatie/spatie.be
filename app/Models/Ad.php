<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }
}
