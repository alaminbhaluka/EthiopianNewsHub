<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
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
