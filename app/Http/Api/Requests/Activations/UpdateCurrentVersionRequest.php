<?php

namespace App\Http\Api\Requests\Activations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrentVersionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_version' => ['required'],
            'arch' => [],
            'platform' => [],
            'os_version' => [],
            'theme' => [],
        ];
    }
}
