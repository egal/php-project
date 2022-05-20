<?php

namespace App\Http\Policies;

use App\Models\Post;
use Egal\Core\Auth\User;

class PostPolicy
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
        return false;
    }

    public function deleteAny(?User $user): bool
    {
        return false;
    }

    public function show(?User $user, Post $post): bool
    {
        return true;
    }

    public function create(?User $user, Post $post): bool
    {
        return false;
    }

    public function update(?User $user, Post $post): bool
    {
        return false;
    }

    public function delete(?User $user, Post $post): bool
    {
        return false;
    }


}
