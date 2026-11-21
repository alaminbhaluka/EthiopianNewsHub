<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, News $news): bool
    {
        return (int) $news->status === 1 && (int) $news->is_approved === 1;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, News $news): bool
    {
        return false;
    }

    public function delete(User $user, News $news): bool
    {
        return false;
    }
}
