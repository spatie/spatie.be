<?php


namespace App\Http\Api\Requests\Activations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrentVersionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'current_version' => ['required'],
        ];
    }
}
