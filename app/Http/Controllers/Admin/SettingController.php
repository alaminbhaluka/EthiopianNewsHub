<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => 'TribuneBangla',
            'site_logo' => 'frontend/assets/images/logo1.png',
            'site_favicon' => 'frontend/assets/images/logo1.png',
            'site_seo_title' => 'TribuneBangla | সত্য ও ন্যায়ের পক্ষে',
            'site_seo_description' => 'বাংলাদেশ ও বিশ্বের সর্বশেষ সংবাদ, বিশ্লেষণ ও প্রতিবেদন।',
            'site_seo_keywords' => 'TribuneBangla, সংবাদ, বাংলাদেশ, খবর',
            'site_color' => '#b20d19',
            'site_microsoft_api_host' => '',
            'site_microsoft_api_key' => '',
        ];

        try {
            $settings = array_merge($settings, Setting::pluck('value', 'key')->toArray());
        } catch (\Throwable $exception) {
            report($exception);
        }

        return view('admin.setting.index', compact('settings'));
    }

    private function saveSetting(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
    }

    public function updateGeneralSetting(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:150'],
            'site_logo' => ['nullable', 'image', 'max:5120'],
            'site_favicon' => ['nullable', 'image', 'max:2048'],
        ]);

        $this->saveSetting('site_name', $request->site_name);

        foreach (['site_logo', 'site_favicon'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('uploads/settings', 'public');
                $this->saveSetting($field, 'storage/' . $path);
            }
        }

        return back()->with('success', 'সাধারণ সেটিংস সংরক্ষণ করা হয়েছে।');
    }

    public function updateSeoSetting(Request $request)
    {
        $request->validate([
            'site_seo_title' => ['required', 'string', 'max:255'],
            'site_seo_description' => ['nullable', 'string', 'max:1000'],
            'site_seo_keywords' => ['nullable', 'string', 'max:1000'],
        ]);

        foreach (['site_seo_title', 'site_seo_description', 'site_seo_keywords'] as $field) {
            $this->saveSetting($field, $request->input($field, ''));
        }

        return back()->with('success', 'SEO সেটিংস সংরক্ষণ করা হয়েছে।');
    }

    public function updateAppearanceSetting(Request $request)
    {
        $request->validate([
            'site_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ]);

        $this->saveSetting('site_color', $request->site_color);

        return back()->with('success', 'ডিজাইন সেটিংস সংরক্ষণ করা হয়েছে।');
    }

    public function updateMicrosoftApiSetting(Request $request)
    {
        $request->validate([
            'site_microsoft_api_host' => ['nullable', 'string', 'max:255'],
            'site_microsoft_api_key' => ['nullable', 'string', 'max:500'],
        ]);

        $this->saveSetting('site_microsoft_api_host', $request->input('site_microsoft_api_host', ''));
        $this->saveSetting('site_microsoft_api_key', $request->input('site_microsoft_api_key', ''));

        return back()->with('success', 'API সেটিংস সংরক্ষণ করা হয়েছে।');
    }
}
