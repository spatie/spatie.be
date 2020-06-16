<?php

namespace App\Models;

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
