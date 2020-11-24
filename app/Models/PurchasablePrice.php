<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasablePrice extends Model
{
    public $casts = [
        'overridden' => 'boolean',
        'amount' => 'integer',
    ];

    public function purchasable(): BelongsTo
    {
        return $this->belongsTo(Purchasable::class);
    }
}
