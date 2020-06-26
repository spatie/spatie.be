<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Paddle\Billable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $casts = [
        'is_admin' => 'bool',
    ];

    public function isSponsoring(): bool
    {
        if ($this->isSpatieMember()) {
            return true;
        }

        return (bool) $this->is_sponsor;
    }

    public function isSpatieMember(): bool
    {
        return Member::where('github', $this->github_username)->exists();
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->with('purchasable.product');
    }
}
