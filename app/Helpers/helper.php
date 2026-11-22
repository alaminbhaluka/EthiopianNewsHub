<?php

use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\Str;

/** format news tags */

function formatTags(array $tags): string
{
   return implode(',', $tags);
}

/** get selected language from session */
function getLangauge(): string
{
    if (session()->has('language')) {
        return session('language');
    }

    try {
        $language = Language::where('default', 1)->first();
        $code = $language && $language->lang ? $language->lang : 'bn';
    } catch (\Throwable $exception) {
        $code = 'bn';
    }

    setLanguage($code);
    return $code;
}

/** set language code in session */
function setLanguage(string $code): void
{
    session(['language' => $code]);
}

/** Truncate text */

function truncate(string $text, int $limit = 45): string
{
    return Str::limit($text, $limit, '...');
}

/** Convert a number in K format */

function convertToKFormat(int $number): string
{
    if($number < 1000){
        return $number;
    }elseif($number < 1000000){
        return round($number / 1000, 1) . 'K';
    }else {
        return round($number / 1000000, 1). 'M';
    }
}

/** Make Sidebar Active */

function setSidebarActive(array $routes): ?string
{
    foreach($routes as $route){
        if(request()->routeIs($route)){
            return 'active';
        }
    }
    return '';
}

/** get Setting */

function getSetting($key){
    $data = Setting::where('key', $key)->first();
    return $data ? $data->value : null;
}

/** Legacy CMS: active admin accounts have administrator access. */
function canAccess(array $permissions)
{
    return auth()->guard('admin')->check()
        && (int) auth()->guard('admin')->user()->status === 1;
}

/** Single-role admin setup (Spatie package is not part of this project). */
function getRole()
{
    return auth()->guard('admin')->check() ? 'Super Admin' : null;
}

/** Check whether the current account is an authenticated admin. */
function checkPermission(string $permission)
{
    return canAccess([$permission]);
}


/** Flash a simple admin toast message without a third-party package. */
function toast(string $message, string $type = 'success')
{
    session()->flash('toast', [
        'message' => $message,
        'type' => in_array($type, ['success', 'error', 'warning', 'info'], true) ? $type : 'info',
    ]);

    return new \App\Support\Toast();
}


/** Format dates using Bengali locale for the public website. */
function banglaDate($date, string $pattern = 'd MMMM yyyy'): string
{
    try {
        $timestamp = $date instanceof \DateTimeInterface ? $date->getTimestamp() : strtotime((string) $date);
        $formatter = new \IntlDateFormatter('bn_BD', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, 'Asia/Dhaka', \IntlDateFormatter::GREGORIAN, $pattern);
        $formatted = $formatter->format($timestamp);
        return $formatted ?: date('d-m-Y', $timestamp);
    } catch (\Throwable $exception) {
        return date('d-m-Y', strtotime((string) $date));
    }
}
