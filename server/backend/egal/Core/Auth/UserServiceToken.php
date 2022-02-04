<?php

namespace Egal\Core\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserServiceToken extends Token
{
    protected string $type = TokenType::USER_SERVICE;
    protected array $authInformation;

    /**
     * @return array
     */
    public function getAuthInformation(): array
    {
        return $this->authInformation;
    }

    /**
     * @param array $authInformation
     */
    public function setAuthInformation(array $authInformation): void
    {
        $this->authInformation = $authInformation;
    }

    public function authInformationAboutRolesExists(): bool
    {
        return array_key_exists('roles', $this->authInformation);
    }

    public function authInformationAboutPermissionsExists(): bool
    {
        return array_key_exists('permissions', $this->authInformation);
    }

    /**
     * @throws UserServiceTokenException
     */
    public function authInformationAboutRolesExistsOrFail(): bool
    {
        if (!$this->authInformationAboutRolesExists()) {
            throw new UserServiceTokenException('Missing information about roles!');
        }
        return true;
    }

    /**
     * @return bool
     * @throws UserServiceTokenException
     */
    public function authInformationAboutPermissionsExistsOrFail(): bool
    {
        if (!$this->authInformationAboutPermissionsExists()) {
            throw new UserServiceTokenException('Missing information about permissions!');
        }
        return true;
    }

    public function getRoles(): array
    {
        if ($this->authInformationAboutRolesExists()) {
            return $this->authInformation['roles'];
        } else {
            return [];
        }
    }

    public function addRole(string $role): self
    {
        if (!isset($this->authInformation['roles'])) {
            $this->authInformation['roles'] = [];
        }
        $this->authInformation['roles'][] = $role;
        $this->authInformation['roles'] = array_unique($this->authInformation['roles']);

        return $this;
    }

    public function addPermission(string $permission): self
    {
        if (!isset($this->authInformation['permissions'])) {
            $this->authInformation['permissions'] = [];
        }
        $this->authInformation['permissions'][] = $permission;
        $this->authInformation['permissions'] = array_unique($this->authInformation['permissions']);

        return $this;
    }

    public function getUid(): string
    {
        return $this->getAuthInformation()['auth_identification'];
    }

    public function getPermissions(): array
    {
        if ($this->authInformationAboutPermissionsExists()) {
            return $this->authInformation['permissions'];
        } else {
            return [];
        }
    }

    /**
     * @return array
     * @throws UserServiceTokenException
     */
    public function toArray(): array
    {
        $this->authInformationAboutRolesExistsOrFail();
        $this->authInformationAboutPermissionsExistsOrFail();
        return [
            'type' => $this->type,
            'auth_information' => $this->authInformation,
            'alive_until' => $this->aliveUntil->toISOString()
        ];
    }

    /**
     * @param array $array
     * @return UserServiceToken
     * @throws InitializeUserServiceTokenException
     */
    public static function fromArray(array $array): UserServiceToken
    {
        Log::debug('array', $array);
        foreach (
            ['type', 'auth_information'] as $index
        ) {
            if (!array_key_exists($index, $array)) {
                throw new InitializeUserServiceTokenException('Incomplete information!');
            }
        }
        $token = new UserServiceToken();
        if (TokenType::USER_SERVICE !== $array['type']) {
            throw new InitializeUserServiceTokenException('Type mismatch!');
        }
        $token->setAuthInformation((array)$array['auth_information']); #TODO: Разобраться зачем приведение типов
        $token->aliveUntil = Carbon::parse($array['alive_until']);
        return $token;
    }
}