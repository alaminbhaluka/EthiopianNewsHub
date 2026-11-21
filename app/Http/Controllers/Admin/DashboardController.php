<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\SocialLink;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'publishedNews' => News::where(['status' => 1, 'is_approved' => 1])->count(),
            'pendingNews' => News::where(['status' => 1, 'is_approved' => 0])->count(),
            'Categories' => Category::count(),
            'languages' => Language::count(),
            'roles' => 1,
            'permissions' => 0,
            'socials' => SocialLink::count(),
            'subscribers' => Subscriber::count(),
        ]);
    }
}
