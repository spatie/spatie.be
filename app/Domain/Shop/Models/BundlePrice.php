<?php

namespace App\Domain\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BundlePrice extends Model
{
    use HasFactory;

    public $casts = [
        'overridden' => 'boolean',
        'amount' => 'integer',
    ];

    /** @return BelongsTo<Bundle, $this> */
    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class);
    }
}
