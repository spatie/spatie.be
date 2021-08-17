<?php

namespace App\Domain\Shop\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Crypto\Rsa\PrivateKey;

class Activation extends Model
{
    use HasFactory;

    protected $casts = [
        'signed_activation' => 'json',
        'expires_at' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function (Activation $activation) {
            $activation->uuid = (string)Str::uuid();
        });
    }

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function updateSignedActivation(): void
    {
        $privateKeyString = $this->license->assignment->purchasable->product->private_key;

        if (empty($privateKeyString)) {
            throw new Exception("Cannot create a signed license for a product without a private key");
        }

        $activationProperties = [
            'activation_code' => $this->uuid,
            'expires_at' => $this->license->expires_at->timestamp,
            'license_key' => $this->license->key,
            'licensed_to' => Str::ascii($this->license->assignment->user->name),
        ];

        ksort($activationProperties);

        $signature = PrivateKey::fromString($privateKeyString)->sign(json_encode($activationProperties));

        $signedActivation = array_merge($activationProperties, compact('signature'));

        $this->update(['signed_activation' => $signedActivation]);
    }
}
