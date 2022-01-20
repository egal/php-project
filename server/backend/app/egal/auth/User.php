<?php

namespace App\egal\auth;

use Illuminate\Support\Facades\Log;

class User extends \App\egal\EgalModel
{
    use HasRoles, HasPermissions, HasAuthorized;

    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    protected function generateAuthInformation(): array
    {
        return array_merge(
            $this->fresh()->toArray(),
            [
                'auth_identification' => $this->getAuthIdentifier(),
                'roles' => $this->getRoles(),
                'permissions' => $this->getPermissions(),
            ]
        );
    }

    static function getModelMetadata()
    {
        // TODO: Implement getModelMetadata() method.
    }

    public function cannot(string $__METHOD__):bool
    {
        Log::debug('into cannot()');
        Log::debug('Session::isUserServiceTokenExists()');
        Log::debug(Session::isUserServiceTokenExists());
        return !Session::isUserServiceTokenExists();
    }
}