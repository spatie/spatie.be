<?php

namespace App\Domain\Experience\Achievements;

use App\Models\Series;

class SeriesAchievement
{
    public function __construct(
        public Series $series,
        public int $userId,
    ) {
    }
}
