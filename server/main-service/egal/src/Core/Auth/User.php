<?php

namespace Egal\Core\Auth;

use Egal\Core\Database\Model;
use Egal\Core\Facades\Gate;
use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;

class User
{

    private readonly string $sub;
    private readonly UserModelInterface $model;

    /**
     * @var string[]
     */
    private array $roles;

    public function __construct(string $sub, array $roles, ?UserModelInterface $model = null)
    {
        $this->sub = $sub;
        $this->roles = $roles;

        if ($model) { # TODO: Implementation working with user model version in current service.
            $this->model = $model;
        }
    }

    public function hasRole(string $name): bool
    {
        return in_array($name, $this->roles);
    }

    public function hasRoles(array $roles): bool
    {
        return count(array_intersect($this->roles, $roles)) == count($roles);
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function makeAccessToken(): string
    {
        return JWT::encode([
            'typ' => 'access',
            'exp' => Carbon::now()->addSeconds(24 * 60 * 60),
            'sub' => $this->sub,
            'roles' => $this->roles,
        ], config('auth.private_key'), 'RS256');
    }

    public function makeRefreshToken(): string
    {
        return JWT::encode([
            'typ' => 'refresh',
            'exp' => Carbon::now()->addSeconds(30 * 24 * 60 * 60),
        ], config('auth.private_key'), 'RS256');
    }

    public function can(Ability $ability, Model|string $model): bool
    {
        return Gate::check($this, $ability, $model);
    }

    public function getSub(): string
    {
        return $this->sub;
    }

}
