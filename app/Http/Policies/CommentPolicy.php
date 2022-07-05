<?php

namespace App\Http\Policies;

use App\Models\Comment;
use Egal\Core\Auth\User;

class CommentPolicy
{

    public function showAny(?User $user): bool
    {
        return true;
    }

    public function createAny(?User $user): bool
    {
        return true;
    }

    public function updateAny(?User $user): bool
    {
        return true;
    }

    public function deleteAny(?User $user): bool
    {
        return true;
    }

    public function show(?User $user, Comment $post): bool
    {
        return true;
    }

    public function create(?User $user, Comment $post): bool
    {
        return true;
    }

    public function update(?User $user, Comment $post): bool
    {
        return true;
    }

    public function delete(?User $user, Comment $post): bool
    {
        return true;
    }


}
