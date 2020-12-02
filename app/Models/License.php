<?php

namespace App\Models;

use DateTimeInterface;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Crypto\PrivateKey;

class License extends Model implements AuthenticatableContract
{
    use HasFactory;

    use Authenticatable;

    protected $casts = [
        'expires_at' => 'datetime',
        'satis_authentication_count' => 'integer',
        'expiration_warning_mail_sent_at' => 'datetime',
        'expiration_mail_sent_at' => 'datetime',
    ];

    public static function booted()
    {
        static::saved(function (License $license) {
            $privateKeyString = $license->purchasable->product->private_key;

            if (! $privateKeyString) {
                return;
            }

            static::withoutEvents(fn () => $license->refresh()->activations->each->updateSignedActivation());
        });
    }

    public function purchasable(): BelongsTo
    {
        return $this->belongsTo(Purchasable::class);
    }

    public function scopeForProduct(Builder $query, Product $product): void
    {
        $query->whereHas('purchasable', fn (
            Builder $query
        ) => $query->where('product_id', $product->id));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function activations(): HasMany
    {
        return $this->hasMany(Activation::class);
    }

    public function hasRepositoryAccess(): bool
    {
        return $this->purchases()
            ->where('has_repository_access', true)
            ->exists();
    }

    public function renew(): self
    {
        $this->update([
            'expires_at' => $this->expirationDateWhenRenewed(),
            'expiration_warning_mail_sent_at' => null,
            'expiration_mail_sent_at' => null,
        ]);

        return $this;
    }

    public function expirationDateWhenRenewed(): DateTimeInterface
    {
        $startDate = $this->expires_at->isFuture()
            ? $this->expires_at
            : now();

        return $startDate->addYear();
    }

    public function isExpired(): bool
    {
        if (is_null($this->expires_at)) {
            return false;
        }

        return $this->expires_at->isPast();
    }

    public function scopeWhereExpired(Builder $query): void
    {
        $query->where('expires_at', '<', now());
    }

    public function scopeWhereNotExpired(Builder $query): void
    {
        $query->where(function (Builder $query): void {
            $query
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    public function getName(): string
    {
        return "{$this->purchasable->product->title}: {$this->purchasable->title}";
    }

    public function isMasterKey(): bool
    {
        return $this->key === config('spatie.master_license_key');
    }

    public function maximumActivationCount(): int
    {
        return $this->purchasable->product->maximum_activation_count;
    }

    public function supportsActivations(): bool
    {
        return $this->maximumActivationCount() > 0;
    }

    protected function updateSignedLicense()
    {
        $privateKeyString = $this->purchasable->product->private_key;

        if (empty($privateKeyString)) {
            throw new Exception("Cannot create a signed license for a product without a private key");
        }

        $licenseProperties = [
            'key' => $this->key,
            'expires_at' => $this->expires_at->timestamp,
        ];

        $signature = PrivateKey::fromString($privateKeyString)->sign(json_encode($licenseProperties));

        $signedLicense = array_merge($licenseProperties, compact('signature'));

        $this->update(['signed_license' => $signedLicense]);
        dump('updated to' . $this->expires_at->timestamp . "(" . $this->expires_at->format('Y-m-d'));
    }
}
