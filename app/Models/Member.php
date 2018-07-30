<?php

namespace App\Models;

use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;

class Member extends Model
{
    public function scopeFounder($query)
    {
        return $query->where('founder', true);
    }

    public function scopeEmployee($query)
    {
        return $query->where('founder', false);
    }

    public function getSlugAttribute(): string
    {
        return strtolower($this->first_name);
    }

    public function getWebsiteDomainAttribute(): string
    {
        return parse_url($this->website)['host'] ?? '';
    }

    public function schema(): Person
    {
        return Schema::person()
            ->name("{$this->first_name} {$this->last_name}")
            ->jobTitle($this->role)
            ->url(array_values(array_filter([
                $this->website,
                $this->twitter ? "https://twitter.com/{$this->twitter}" : null,
            ])))
            ->if($this->public_email, function ($person) {
                $person->email($this->email);
            });
    }
}
