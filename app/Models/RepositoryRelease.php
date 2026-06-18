<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepositoryRelease extends Model
{
    use HasFactory;

    protected $casts = [
        'is_release' => 'boolean',
        'is_prerelease' => 'boolean',
        'released_at' => 'datetime',
    ];

    /** @return BelongsTo<Repository, $this> */
    public function repository(): BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }
}
