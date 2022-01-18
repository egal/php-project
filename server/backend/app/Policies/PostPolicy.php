<?php

namespace App\Policies;

use App\egal\auth\User;
use App\egal\EgalHttpPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PostPolicy extends EgalHttpPolicy
{
    public function index(User $user, Collection $entity)
    {
        return true;
    }

    public function show(User $user, Model $entity)
    {
        return false;
    }

    public function create(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

    // до тех endpoint, которые отсутствуют, доступ закрыт
}