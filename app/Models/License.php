<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class License extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $casts = [
        'expires_at' => 'datetime',
        'satis_authentication_count' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return optional($this->expires_at)->isPast() ?? false;
    }
}
