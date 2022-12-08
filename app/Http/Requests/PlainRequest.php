<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlainRequest extends FormRequest
{
    public function email(): string
    {
        return $this->json('customer.email');
    }
}
