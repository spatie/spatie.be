<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $casts = [
        'paddle_webhook_payload' => 'array',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function purchasable(): BelongsTo
    {
        return $this->belongsTo(Purchasable::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereUser(Builder $query, User $user)
    {
        $query->where('user_id', $user->id);
    }

    public function scopeForProduct(Builder $query, Product $product)
    {
        $query->whereHas('purchasable', fn (Builder $query) => $query->where('product_id', $product->id));
    }
}
