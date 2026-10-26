<?php

namespace App\Services\GitHub;

enum RepositoryAccessStatus: string
{
    case Granted = 'granted';
    case Pending = 'pending';
    case Missing = 'missing';
    case Unknown = 'unknown';
}
