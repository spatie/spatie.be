<?php

use App\Domain\Shop\Enums\SeriesType;
use App\Models\Series;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultSeriesType extends Migration
{
    public function up()
    {
        Series::query()->update([
            'type' => SeriesType::Video->value
        ]);
    }
}
