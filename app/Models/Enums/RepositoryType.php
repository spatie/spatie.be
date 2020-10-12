<?php

namespace App\Models\Enums;

use MyCLabs\Enum\Enum;

/** @psalm-immutable */
class RepositoryType extends Enum
{
    const PACKAGE = 'package';
    const PROJECT = 'project';
}
