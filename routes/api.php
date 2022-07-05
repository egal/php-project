<?php

use App\Http\Policies\PostPolicy;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Post;
use Egal\Core\Facades\Route as EgalRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
# TODO: Header accept with value application/json.


Route::get('/', fn() => response()->json(['message' => 'Hello!']));
//
//EgalRoute::rest(Post::class, PostPolicy::class);
EgalRoute::rest(Post::class, PostPolicy::class);
//EgalRoute::rest(Comment::class, \App\Http\Policies\CommentPolicy::class);
//EgalRoute::rest(Channel::class, \App\Http\Policies\ChannelPolicy::class);

Route::post('/http-build-query', function (Request $request) {
    return response(http_build_query(json_decode($request->getContent(), true)), 200);
});

# TODO: Отдельный сервис.
Route::get('/interface-metadata/{label}', [\Egal\Interface\Http\Controller::class, 'show']);

//EgalRoute::rest(\App\Models\Like::class, \App\Http\Policies\LikePolicy::class);
