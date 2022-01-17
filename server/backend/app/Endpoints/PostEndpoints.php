<?php

namespace App\Endpoints;

use App\egal\EgalEndpoints;
use App\Models\Post;

class PostEndpoints extends EgalEndpoints
{
    function model()
    {
        return new Post();
    }
}
