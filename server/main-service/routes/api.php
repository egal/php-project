<?php

use App\Http\Policies\PostPolicy;
use App\Models\Post;
use Egal\Core\Facades\Gate;
use Egal\Core\Facades\Route as EgalRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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


Route::get('/', fn() => response()->json(['message' => 'Hello!']));

EgalRoute::rest(Post::class, PostPolicy::class);

Route::post('/http-build-query', function (Request $request) {
    return response(http_build_query(json_decode($request->getContent(), true)), 200);
});

# TODO: Вынести в библиотеку.
Route::post('/login', function (Request $request) {
    $user = new \Egal\Core\Auth\User(Str::uuid(), []);
    return response()->json([
        'access_token' => $user->makeAccessToken(),
        'refresh_token' => $user->makeRefreshToken(),
    ]);
});

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
