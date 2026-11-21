<?php

namespace App\Http\Middleware;

use App\Models\News;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckArticleOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $articleId = $request->route('article') ?: $request->route('id');
        if ($articleId) {
            $article = News::findOrFail($articleId);
            if ((int) $article->auther_id !== (int) $admin->id) {
                abort(403);
            }
        }

        return $next($request);
    }
}
