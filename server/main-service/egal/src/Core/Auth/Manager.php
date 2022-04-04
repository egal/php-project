<?php

namespace Egal\Core\Auth;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Manager
{

    private ?User $user;

    public function authenticate(?string $token): User|null
    {
        if ($token === null) {
            $this->user = null;
            return $this->user;
        }

        $decoded = JWT::decode($token, new Key(config('auth.public_key'), 'RS256'));

        if ($decoded->typ !== 'access') {
            throw new Exception('Invalid token type!');
        }

        $userModel = null;

        if ($userModelClass = config('auth.user_model_class')) {
            $userModel = new $userModelClass();

            if (!($userModel instanceof UserModelInterface)) {
                throw new Exception('Error! User model class must be implements of ' . UserModelInterface::class . '!');
            }

            $userModel = $userModel->findBySub($decoded->sub);
        }

        $this->user = new User($decoded->sub, $decoded->roles, $userModel);

        return $this->user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

}
