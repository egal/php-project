<?php

namespace Egal\Core\Auth;

use Carbon\Carbon;
use Egal\Core\Database\Model;
use Egal\Core\Exceptions\NoAccessException;

class Gate
{

    private bool $enabled = true; # TODO: From config and for RPC disabled always.

    private array $policies = [];

    /**
     * @param class-string $class
     * @param class-string $policy
     */
    public function registerPolicy(string $class, string $policy): void
    {
        $this->policies[$class] = new $policy();
    }

    /**
     * @param Model|class-string $model
     */
    public function check(?User $user, Ability $ability, Model|string $model): bool
    {
        if (!$this->enabled) {
            return true;
        }

        $policy = $this->policies[is_object($model) ? get_class($model) : $model] ?? null; # TODO: Many policies.

        if ($policy === null) {
            return false;
        }

//        dd($policy->{$ability->name}($user));

        return is_object($model)
            ? $policy->{$ability->name}($user, $model)
            : $policy->{$ability->name}($user);
    }

    /**
     * @param Model|class-string $model
     */
    public function allowed(?User $user, Ability $ability, Model|string $model): bool
    {
        if ($this->check($user, $ability, $model) === false) {
            throw new NoAccessException();
        }

        return true;
    }

}
