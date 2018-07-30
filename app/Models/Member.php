<?php

namespace App\Models;

class Member extends Model
{
    public function getSlugAttribute(): string
    {
        return strtolower($this->first_name);
    }

    public function getWebsiteDomainAttribute(): string
    {
        return parse_url($this->website)['host'] ?? '';
    }
}
