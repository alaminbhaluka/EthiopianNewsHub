<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $language = Language::firstOrCreate(
            ['lang' => 'bn'],
            ['name' => 'বাংলা', 'slug' => 'বাংলা', 'default' => 1, 'status' => 1]
        );
        Language::where('id', '!=', $language->id)->update(['default' => 0]);
        $language->default = 1;
        $language->status = 1;
        $language->save();

        $categories = [
            ['জাতীয়', 'national'],
            ['রাজনীতি', 'politics'],
            ['আন্তর্জাতিক', 'international'],
            ['সারাদেশ', 'country'],
            ['অর্থনীতি', 'economy'],
            ['খেলাধুলা', 'sports'],
            ['বিনোদন', 'entertainment'],
            ['শিক্ষা', 'education'],
            ['প্রযুক্তি', 'technology'],
            ['স্বাস্থ্য', 'health'],
            ['মতামত', 'opinion'],
            ['ভিডিও', 'video'],
        ];

        foreach ($categories as [$name, $slug]) {
            Category::firstOrCreate(
                ['language' => 'bn', 'slug' => $slug],
                ['name' => $name, 'show_at_nav' => 1, 'status' => 1]
            );
        }

        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password || Admin::where('email', $email)->exists()) {
            return;
        }

        $admin = new Admin();
        $admin->name = env('ADMIN_NAME', 'TribuneBangla Administrator');
        $admin->email = $email;
        $admin->password = Hash::make($password);
        $admin->image = 'frontend/assets/images/logo1.png';
        $admin->status = 1;
        $admin->save();
    }
}
