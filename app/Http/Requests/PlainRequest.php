<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlainRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function email(): string
    {
        return $this->json('customer.email') ?? '';
    }
}
