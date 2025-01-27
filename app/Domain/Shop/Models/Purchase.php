<?php

namespace App\Domain\Shop\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Paddle\Receipt;

class Purchase extends Model
{
    use HasFactory;

    protected $casts = [
        'paddle_webhook_payload' => 'array',
        'has_repository_access' => 'boolean',
        'discount_starts_at' => 'datetime',
        'discount_expires_at' => 'datetime',
        'passthrough' => 'array',
    ];

    public function licenses(): HasManyThrough
    {
        return $this->hasManyThrough(License::class, PurchaseAssignment::class);
    }

    /** @return BelongsTo<Purchasable, $this> */
    public function purchasable(): BelongsTo
    {
        return $this->belongsTo(Purchasable::class);
    }

    /** @return BelongsTo<Bundle, $this> */
    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class);
    }

    /** @return HasMany<PurchaseAssignment, $this> */
    public function assignments(): HasMany
    {
        return $this->hasMany(PurchaseAssignment::class);
    }

    public function getPurchasables(): Collection
    {
        return $this->bundle
            ? $this->bundle->purchasables
            : collect([$this->purchasable]);
    }

    public function getPurchasablesForProduct(Product $product): Collection
    {
        return $this->bundle
            ? $this->bundle->purchasables->where('product_id', $product->id)
            : collect([$this->purchasable]);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Receipt, $this> */
    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function scopeWhereUser(Builder $query, User $user): void
    {
        $query->where('user_id', $user->id);
    }

    public function scopeForProduct(Builder $query, Product $product): void
    {
        $query->whereHas('purchasable', fn (Builder $query) => $query->where('product_id', $product->id))
            ->orWhereHas('bundle', function (Builder $query) use ($product) {
                $query->whereHas('purchasables', fn (Builder $query) => $query->where('product_id', $product->id));
            });
    }

    public function hasAccessToVideos(): bool
    {
        if ($this->bundle) {
            return $this->bundle->purchasables()->has('series')->count() > 0;
        }

        return $this->purchasable->series->count() > 0;
    }

    public function wasMadeForLicense(): ?License
    {
        if (! $licenseId = Arr::get($this->passthrough, 'license_id')) {
            return null;
        }

        if (! $license = License::find($licenseId)) {
            return null;
        }

        return $license;
    }

    public function unlocksRayLicense(): bool
    {
        return false;
    }
}
