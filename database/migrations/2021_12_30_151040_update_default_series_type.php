<?php

use App\Domain\Shop\Enums\SeriesType;
use App\Models\Series;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Series::query()->update([
            'type' => SeriesType::Video->value,
        ]);
    }
};
