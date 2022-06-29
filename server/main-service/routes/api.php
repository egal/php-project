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

EgalRoute::rest(Post::class, PostPolicy::class);
EgalRoute::rest(Post::class, PostPolicy::class);
EgalRoute::rest(Comment::class, \App\Http\Policies\CommentPolicy::class);
EgalRoute::rest(Channel::class, \App\Http\Policies\ChannelPolicy::class);

Route::post('/http-build-query', function (Request $request) {
    return response(http_build_query(json_decode($request->getContent(), true)), 200);
});

# TODO: Вынести в библиотеку.
Route::post('/register', [\Egal\Core\Auth\SessionController::class, 'register']);
Route::post('/login', [\Egal\Core\Auth\SessionController::class, 'login']);
Route::post('/jwt/register', [\Egal\Core\Auth\TokenController::class, 'register']);
Route::post('/jwt/login', [\Egal\Core\Auth\TokenController::class, 'login']);


# TODO: Отдельный сервис.
Route::get('/interface-metadata{route_line}', function (Request $request) {
    $segments = $request->segments();
    $segments[0] = 'interface_metadata';
    $config = config(implode('.', $segments));

    if (!$config) {
        return response()->noContent(404);
    }

    return response()->json($config);
})->where('route_line', '.*');

EgalRoute::rest(\App\Models\Like::class, \App\Http\Policies\LikePolicy::class);
