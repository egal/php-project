<?php

namespace App\egal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EgalPolicy
{
    protected $config;

    public function index(Model $user, Collection $entity)
    {
        $indexRoles = $this->config[__METHOD__];
        return isset($indexRoles) || in_array(Auth::getRoles(), $indexRoles);
    }

    public function show(Model $user, Model $entity)
    {
        $showRoles = $this->config[__METHOD__];
        return isset($showRoles) || in_array(Auth::getRoles(), $showRoles);
    }

    public function create(Model $user, Model $entity)
    {
        $createRoles = $this->config[__METHOD__];
        return isset($createRoles) || in_array(Auth::getRoles(), $createRoles);
    }

    public function update(Model $user, Model $entity)
    {
        $updateRoles = $this->config[__METHOD__];
        return isset($updateRoles) || in_array(Auth::getRoles(), $updateRoles);
    }

    public function delete(Model $user, Model $entity)
    {
        $deleteRoles = $this->config[__METHOD__];
        return isset($deleteRoles) || in_array(Auth::getRoles(), $deleteRoles);
    }
}