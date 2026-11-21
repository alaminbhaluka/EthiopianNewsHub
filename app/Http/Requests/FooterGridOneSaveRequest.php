<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterGridOneSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'language' => ['required', 'exists:languages,lang'],
            'name' => ['required', 'string', 'max:150'],
            'url' => ['required', 'string', 'max:2048'],
            'status' => ['required', 'boolean'],
        ];
    }
}
