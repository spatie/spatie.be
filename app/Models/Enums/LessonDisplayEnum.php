<?php

namespace App\Models\Enums;

use MyCLabs\Enum\Enum;

/** @psalm-immutable */
class LessonDisplayEnum extends Enum
{
    public const FREE = 'free';
    public const AUTH = 'auth';
    public const SPONSORS = 'sponsors';
    public const LICENSE = 'license';
}
