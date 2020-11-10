<?php

namespace App\Rules;

use App\Models\Activation;
use App\Models\License;
use Illuminate\Contracts\Validation\Rule;

class MatchingLicense implements Rule
{
    protected Activation $activation;

    public function __construct(Activation $activation)
    {
        $this->activation = $activation;
    }

    public function passes($attribute, $licenseKey)
    {
        /** @var License $license */
        if (! $license = License::firstWhere('key', $licenseKey)) {
            return false;
        }

        return $license->activations()->where('id', $this->activation->id)->exists();
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
