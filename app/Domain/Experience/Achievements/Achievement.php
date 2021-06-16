<?php

namespace App\Domain\Experience\Achievements;

interface Achievement
{
    public function getSlug(): string;

    public function getTitle(): string;

    public function getDescription(): string;
}
