<?php

namespace App\Rules;

use App\Domain\Shop\Models\Activation;
use App\Domain\Shop\Models\License;
use Illuminate\Contracts\Validation\Rule;

class MatchingLicense implements Rule
{
    protected Activation $activation;

    public function __construct(Activation $activation)
    {
        $this->activation = $activation;
    }

    public function passes($attribute, $value): bool
    {
        /** @var License|null $license */
        if (! $license = License::firstWhere('key', $value)) {
            return false;
        }

        return $license->activations()->where('id', $this->activation->id)->exists();
    }

    public function message(): string
    {
        return 'The validation error message.';
    }
}
