<?php

namespace App\Policies;

use App\egal\auth\User;
use App\egal\EgalHttpPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PostPolicy extends EgalHttpPolicy
{
    // если политики нет, то методы всем доступны
    // при генерации все методы политики возвращают false
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

    public function update(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

    public function beforeIndex(User $user, Collection $entity)
    {
        return true;
    }

    public function beforeShow(User $user, Model $entity)
    {
        return false;
    }

    public function beforeCreate(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

    public function beforeUpdate(User $user, Model $entity) // entity со всеми атрибутами
    {
        return $user->hasRole('admin');
    }

    public function beforeDelete(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

    public function showTitle(User $user, Model $entity)
    {
        return false;
    }

    public function createTitle(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

    public function updateTitle(User $user, Model $entity)
    {
        return $user->hasRole('admin');
    }

}