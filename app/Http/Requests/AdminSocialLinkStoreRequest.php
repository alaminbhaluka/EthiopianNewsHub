<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSocialLinkStoreRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'icon' => ['required', 'string', 'max:150'],
            'url' => ['required', 'string', 'max:2048'],
            'status' => ['required', 'boolean'],
        ];
    }
}
