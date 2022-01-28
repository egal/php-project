<?php

namespace App\Policies;

use Egal\Core\Auth\User;
use Egal\Core\Model\HttpPolicy;
use Illuminate\Database\Eloquent\Model;

class ChannelPolicy extends HttpPolicy
{

    public function endpointCreate(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

    public function endpointUpdate(User $user, Model $entity): bool // entity со всеми атрибутами
    {
        return $user->hasRole('admin');
    }

    public function endpointDelete(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

}