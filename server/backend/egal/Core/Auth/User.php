<?php

namespace Egal\Core\Auth;

use Egal\Core\Model\Model;
use Egal\Core\Model\Metadata\ModelMetadata;

class User extends Model
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

    static function getModelMetadata(): ModelMetadata
    {
        // TODO: Implement getModelMetadata() method.
    }

    public function cannot(string $method, Model $entity):bool
    {
        $policyClass = "App\\Policies\\" . $entity->getName() . "Policy";
        if (!class_exists($policyClass)) {
            return false;
        }
        $policy = new $policyClass();
        return !$policy->$method($this, $entity);
    }
}