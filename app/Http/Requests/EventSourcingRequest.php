<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventSourcingRequest extends FormRequest
{
    public function rules(): array
    {
        return ['email' => 'required', 'email'];
    }
}
