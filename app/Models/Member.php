<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;

class Member extends Model
{
    use HasFactory;

    protected $casts = [
        'birthday' => 'datetime:Y-m-d',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public function name(): string
    {
        return ucfirst($this->preferred_name ?? $this->first_name);
    }

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
        $profiles = collect([
            $this->twitter ? "https://x.com/{$this->twitter}" : null,
            $this->github ? "https://github.com/{$this->github}" : null,
        ])
            ->filter()
            ->values()
            ->all();

        return Schema::person()
            ->name("{$this->first_name} {$this->last_name}")
            ->jobTitle($this->role)
            ->if($this->website, function (Person $person): void {
                $person->url($this->website);
            })
            ->sameAs($profiles)
            ->if($this->public_email, function ($person): void {
                $person->email($this->email);
            });
    }
}
