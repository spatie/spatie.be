<?php

namespace App\Models\Enums;

use MyCLabs\Enum\Enum;

class VideoDisplayEnum extends Enum
{
    const FREE = 'free';
    const AUTH = 'auth';
    const SPONSORS = 'sponsors';
    const LICENSE = 'license';
}
