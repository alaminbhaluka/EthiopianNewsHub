<?php

namespace App\Listeners;

use App\Events\ArticleSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateArticleSeo implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ArticleSubmitted $event): void
    {
        // Listener hook retained for future event-specific processing.
    }
}
