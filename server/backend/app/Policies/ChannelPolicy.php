<?php

namespace App\Policies;

use Egal\Auth\User;
use Egal\Core\EgalHttpPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ChannelPolicy extends EgalHttpPolicy
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