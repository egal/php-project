<?php

namespace App\Policies;

use Egal\Core\Auth\User;
use Egal\Core\Model\HttpPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TestPolicy extends HttpPolicy
{

    public function endpointIndex(User $user, Collection $entity): bool
    {
        return false;
    }

    public function endpointShow(User $user, Model $entity): bool
    {
        return false;
    }

    public function endpointCreate(User $user, Model $entity): bool
    {
        return false;
    }

    public function endpointUpdate(User $user, Model $entity): bool
    {
        return false;
    }

    public function endpointDelete(User $user, Model $entity): bool
    {
        return false;
    }

    public function index(User $user, Collection $entity): bool
    {
        return false;
    }

    public function show(User $user, Model $entity): bool
    {
        return false;
    }

    public function create(User $user, Model $entity): bool
    {
        return false;
    }

    public function update(User $user, Model $entity): bool
    {
        return false;
    }

    public function delete(User $user, Model $entity): bool
    {
        return false;
    }

     public function showTitle(User $user, Model $entity): bool
    {
        return false;
    }

    public function createTitle(User $user, Model $entity): bool
    {
        return false;
    }

    public function updateTitle(User $user, Model $entity): bool
    {
        return false;
    }
     public function showDescription(User $user, Model $entity): bool
    {
        return false;
    }

    public function createDescription(User $user, Model $entity): bool
    {
        return false;
    }

    public function updateDescription(User $user, Model $entity): bool
    {
        return false;
    }

}