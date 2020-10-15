<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'required_if:newsletter'],
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
