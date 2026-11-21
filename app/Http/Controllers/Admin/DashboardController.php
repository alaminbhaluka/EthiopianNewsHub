<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\SocialLink;
use App\Models\Subscriber;
use App\Services\TribuneNewsService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(TribuneNewsService $tribuneNews): View
    {
        return view('admin.dashboard.index', [
            'publishedNews' => $tribuneNews->publishedNews(200)->count(),
            'pendingNews' => News::where(['status' => 1, 'is_approved' => 0])->count(),
            'Categories' => $tribuneNews->categories()->count(),
            'languages' => Language::count(),
            'roles' => 1,
            'permissions' => 0,
            'socials' => SocialLink::count(),
            'subscribers' => Subscriber::count(),
        ]);
    }
}
