<?php

namespace App\Exceptions;

use App\Models\License;
use Exception;

class MaximumActivationsReached extends Exception
{
    public static function make(License $license)
    {
        return new static("Could not create a new activation because the maximum of {$license->maximumActivationCount()} was reached.");
    }
}
