<?php

namespace App\Http\Policies;

use App\Models\Channel;
use Egal\Core\Auth\User;

class ChannelPolicy
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

    public function show(?User $user, Channel $post): bool
    {
        return true;
    }

    public function create(?User $user, Channel $post): bool
    {
        return true;
    }

    public function update(?User $user, Channel $post): bool
    {
        return true;
    }

    public function delete(?User $user, Channel $post): bool
    {
        return true;
    }


}
