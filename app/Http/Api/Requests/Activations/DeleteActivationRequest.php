<?php

namespace App\Http\Api\Requests\Activations;

use App\Rules\MatchingLicense;
use Illuminate\Foundation\Http\FormRequest;

class DeleteActivationRequest extends FormRequest
{
    public function rules()
    {
        return [
        ];
    }
}
