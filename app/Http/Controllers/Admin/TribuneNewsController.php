<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TribuneNewsService;
use Illuminate\Contracts\View\View;

class TribuneNewsController extends Controller
{
    public function index(TribuneNewsService $tribuneNews): View
    {
        $news = $tribuneNews->publishedNews(200);

        return view('admin.tribune-news.index', compact('news'));
    }
}
