<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\TribuneNewsService;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('frontend.layouts.master', function ($view) {
            $settings = [
                'site_logo' => 'frontend/assets/images/logo1.png',
                'site_favicon' => 'frontend/assets/images/logo1.png',
                'site_color' => '#b20d19',
                'site_seo_title' => 'TribuneBangla | সত্য ও ন্যায়ের পক্ষে',
                'site_seo_description' => 'বাংলাদেশ ও বিশ্বের সর্বশেষ সংবাদ, বিশ্লেষণ ও প্রতিবেদন।',
                'site_seo_keywords' => 'TribuneBangla, সংবাদ, বাংলাদেশ, খবর',
            ];

            try {
                $settings = array_merge($settings, Setting::pluck('value', 'key')->toArray());
            } catch (\Throwable $exception) {
                report($exception);
            }

            $view->with('settings', $settings);
            $view->with('siteCategories', app(TribuneNewsService::class)->categories());
        });
    }
}
