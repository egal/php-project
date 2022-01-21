<?php

namespace App\Policies;

use Egal\Auth\User;
use Egal\Core\EgalHttpPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PostPolicy extends EgalHttpPolicy
{
    // если политики нет, то методы всем доступны
    // при генерации все методы политики возвращают false

    public function index(User $user, Collection $entity): bool
    {
        return true;
    }

    public function show(User $user, Model $entity): bool
    {
        return false;
    }

    public function create(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

    public function endpointIndex(User $user, Collection $entity): bool
    {
        return true;
    }

    public function endpointShow(User $user, Model $entity): bool
    {
        return false;
    }

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

    public function showTitle(User $user, Model $entity): bool
    {
        return false;
    }

    public function createTitle(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

    public function updateTitle(User $user, Model $entity): bool
    {
        return $user->hasRole('admin');
    }

}