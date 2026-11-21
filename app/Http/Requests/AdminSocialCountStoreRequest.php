<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSocialCountStoreRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'language' => ['required', 'exists:languages,lang'],
            'icon' => ['required', 'string', 'max:150'],
            'url' => ['required', 'string', 'max:2048'],
            'fan_count' => ['required', 'string', 'max:80'],
            'fan_type' => ['required', 'string', 'max:80'],
            'button_text' => ['required', 'string', 'max:100'],
            'color' => ['required', 'string', 'max:50'],
            'status' => ['required', 'boolean'],
        ];
    }
}
