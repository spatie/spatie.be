<?php

namespace App\Models\Enums;

use MyCLabs\Enum\Enum;

class RepositoryType extends Enum
{
    const PACKAGE = 'package';
    const PROJECT = 'project';
}
