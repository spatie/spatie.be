<?php

namespace App\Domain\Shop\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function scopeForProduct(Builder $query, Product $product): void
    {
        $query->whereIn('purchasable_id', $product->purchasables->pluck('id'));
    }

    public function scopeWhereUser(Builder $query, User $user): void
    {
        $query->where('user_id', $user->id);
    }

    public function scopeWherePurchase(Builder $query, Purchase $purchase): void
    {
        $query->where('purchase_id', $purchase->id);
    }
}
