<?php

namespace App\Services;

use App\egal\EgalService;
use App\Models\Post;

class PostService extends EgalService
{
    function model()
    {
        return new Post();
    }
}
