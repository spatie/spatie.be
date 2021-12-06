<?php

namespace App\Models\Enums;

use MyCLabs\Enum\Enum;

/** @psalm-immutable */
class RepositoryType extends Enum
{
    public const PACKAGE = 'package';
    public const PROJECT = 'project';
}
