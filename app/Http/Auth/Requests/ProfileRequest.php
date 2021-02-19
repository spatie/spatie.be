<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', Rule::unique('users', 'email')->whereNot('id', auth()->user()->id)],
            'newsletter' => ['nullable'],
        ];
    }

    public function getUserAttributes(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
