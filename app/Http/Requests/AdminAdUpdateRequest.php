<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAdUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'home_top_bar_ad' => ['nullable', 'image', 'max:5120'],
            'home_middle_ad' => ['nullable', 'image', 'max:5120'],
            'view_page_ad' => ['nullable', 'image', 'max:5120'],
            'news_page_ad' => ['nullable', 'image', 'max:5120'],
            'side_bar_ad' => ['nullable', 'image', 'max:5120'],
            'home_top_bar_ad_url' => ['nullable', 'string', 'max:2048'],
            'home_middle_ad_url' => ['nullable', 'string', 'max:2048'],
            'view_page_ad_url' => ['nullable', 'string', 'max:2048'],
            'news_page_ad_url' => ['nullable', 'string', 'max:2048'],
            'side_bar_ad_url' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
