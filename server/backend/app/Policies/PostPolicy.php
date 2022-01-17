<?php

namespace App\Policies;

use App\egal\EgalPolicy;

class PostPolicy extends EgalPolicy
{
    protected $config = [
        'index' => ['admin', 'logged'],
        'update' => ['admin']
    ];

}