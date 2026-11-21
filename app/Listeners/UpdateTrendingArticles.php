<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTrendingArticles implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ArticlePublished $event): void
    {
        // Listener hook retained for future event-specific processing.
    }
}
