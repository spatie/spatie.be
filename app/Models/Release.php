<?php

namespace App\Models;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Release extends Model
{
    use HasFactory;

    public $guarded = [];

    public $casts = [
        'released' => 'bool',
        'released_at' => 'datetime',
    ];

    public static function booted()
    {
        static::saving(function (Release $release) {
            $release->notes_html = Markdown::convertToHtml($release->notes);
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
