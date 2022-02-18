<?php

namespace Egal\Core\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Manager
{

    private User $user;

    public function authenticate(string $jwt): User
    {
        $payload = JWT::decode($jwt, new Key(config('auth.public_key'), 'RS256'));

        $this->setUser();

        return $this->user;
    }

    private function setUser(User $user): void
    {
        $this->user = $user;
    }

}
