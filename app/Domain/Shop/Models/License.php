<?php

namespace App\Domain\Shop\Models;

use App\Models\User;
use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Crypto\Rsa\PrivateKey;

class License extends Model implements AuthenticatableContract
{
    use HasFactory;

    use Authenticatable;

    protected $casts = [
        'expires_at' => 'datetime',
        'satis_authentication_count' => 'integer',
        'expiration_warning_mail_sent_at' => 'datetime',
        'expiration_mail_sent_at' => 'datetime',
        'second_expiration_mail_sent_at' => 'datetime',
    ];

    public static function booted()
    {
        static::saved(function (License $license) {
            $privateKeyString = $license->assignment?->purchasable->product->private_key;

            if (! $privateKeyString) {
                return;
            }

            static::withoutEvents(
                fn () => $license
                ->refresh()
                ->activations
                ->each(fn (Activation $activation) => $activation->updateSignedActivation())
            );
        });
    }

    /** @return BelongsTo<PurchaseAssignment, $this> */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(PurchaseAssignment::class, 'purchase_assignment_id');
    }

    public function scopeForProduct(Builder $query, Product $product): void
    {
        $query->whereHas('assignment.purchasable', fn (
            Builder $query
        ) => $query->where('product_id', $product->id));
    }

    /** @return HasMany<Activation, $this> */
    public function activations(): HasMany
    {
        return $this->hasMany(Activation::class);
    }

    public function hasRepositoryAccess(): bool
    {
        return $this->assignment?->has_repository_access;
    }

    public function renew(): self
    {
        $attributes = [
            'expires_at' => $this->expirationDateWhenRenewed(),
            'expiration_warning_mail_sent_at' => null,
            'expiration_mail_sent_at' => null,
            'second_expiration_mail_sent_at' => null,
        ];

        $this->update($attributes);

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

    public function isLifetime(): bool
    {
        return $this->expires_at > Carbon::create(2038);
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
        return "{$this->assignment->purchasable->product->title}";
    }

    public function isMasterKey(): bool
    {
        return $this->key === config('spatie.master_license_key');
    }

    public function maximumActivationCount(): int
    {
        return $this->assignment->purchasable->product->maximum_activation_count;
    }

    public function supportsActivations(): bool
    {
        return $this->maximumActivationCount() > 0;
    }

    public function isAssignedTo(User $user)
    {
        return $this->assignment->user_id === $user->id;
    }

    public function coversRepo(string $repo): bool
    {
        return in_array($repo, $this->assignment->purchasable->satis_packages);
    }

    protected function updateSignedLicense()
    {
        $privateKeyString = $this->assignment->purchasable->product->private_key;

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
    }

    public function concernsRay(): bool
    {
        return strtolower($this->assignment?->purchasable?->product?->title) === 'ray';
    }
}
