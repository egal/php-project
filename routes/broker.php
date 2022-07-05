<?php

use App\Models\Post;
use Egal\Core\Rpc\Route as EgalRoute;

/*
|--------------------------------------------------------------------------
| Broker Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Broker routes for your application.
|
*/

EgalRoute::rest(Post::class); # TODO: Implementation.
