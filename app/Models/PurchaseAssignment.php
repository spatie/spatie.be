<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Paddle\Receipt;

class PurchaseAssignment extends Model
{
    use HasFactory;

    protected $casts = [
        'has_repository_access' => 'boolean',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function purchasable(): BelongsTo
    {
        return $this->belongsTo(Purchasable::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function scopeForProduct(Builder $query, Product $product): void
    {
        $query->whereIn('purchasable_id', $product->purchasables->pluck('id'));
    }
}
