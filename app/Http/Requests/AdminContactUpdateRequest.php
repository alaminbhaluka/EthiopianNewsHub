<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminContactUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'language' => ['required', 'exists:languages,lang'],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:190'],
        ];
    }
}
