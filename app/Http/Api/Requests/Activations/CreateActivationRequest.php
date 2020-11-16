<?php

namespace App\Http\Api\Requests\Activations;

use App\Models\License;
use Illuminate\Foundation\Http\FormRequest;

class CreateActivationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'license_key' => 'required|exists:licenses,key',
        ];
    }

    public function license(): License
    {
        return License::query()->firstWhere('key', $this->license_key);
    }
}
