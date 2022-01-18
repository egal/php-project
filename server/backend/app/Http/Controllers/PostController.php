<?php

namespace App\Http\Controllers;

use App\Endpoints\PostEndpoints;

class PostController
{
    public function custom()
    {
        return (new PostEndpoints())->custom();
    }
}