<?php

namespace App\Http\Policies;

use App\Models\Like;
use Egal\Core\Auth\User;

class LikePolicy
{
     public function showAny(?User $user): bool
        {
            return false;
        }

        public function createAny(?User $user): bool
        {
            return false;
        }

        public function updateAny(?User $user): bool
        {
            return false;
        }

        public function deleteAny(?User $user): bool
        {
            return false;
        }

        public function show(?User $user, Like $post): bool
        {
            return false;
        }

        public function create(?User $user, Like $post): bool
        {
            return false;
        }

        public function update(?User $user, Like $post): bool
        {
            return false;
        }

        public function delete(?User $user, Like $post): bool
        {
            return false;
        }
}
