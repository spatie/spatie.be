<?php

namespace App\Services\GitHub\Exceptions;

use RuntimeException;
use Throwable;

class GitHubTwoFactorAuthenticationRequired extends RuntimeException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct(
            'Your GitHub account is connected, but GitHub rejected repository access because of its two-factor authentication requirements. Configure a secure two-factor method and remove SMS authentication in your GitHub security settings, then retry granting repository access. Contact support if this is already configured.',
            previous: $previous,
        );
    }
}
