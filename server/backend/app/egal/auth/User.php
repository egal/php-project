<?php

namespace App\egal\auth;

class User extends \App\egal\EgalModel
{
    use HasRoles, HasPermissions, HasAuthorized;

    static function getModelMetadata()
    {
        // TODO: Implement getModelMetadata() method.
    }
}