<?php

namespace App\DataTransferObjects;

class SeriesProgress
{
    public function __construct(
        public int $total,
        public int $completed,
    ) {
    }
}
