<?php

use App\Models\Post;
use Egal\Core\Database\Model;
use Egal\Core\Routing\Route as EgalRoute;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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

EgalRoute::rest(Post::class);

Route::post('/http-build-query', function (Request $request) {
    return response(http_build_query(json_decode($request->getContent(), true)), 200);
});

# TODO: Вынести в библиотеку.
Route::post('/auth/login', function (Request $request) {
    $payload = [
        # TODO: exp
        'sub' => Str::uuid(),
        'roles' => [],
        'permission' => [],
    ];

    return response()->json([
        'token' => JWT::encode($payload, config('auth.service.private_key'), 'RS256'),
        'reset_token' => ''
    ]);
});

Route::post('/service/auth/login', function (Request $request) {
    $decoded = JWT::decode(
        $request->header('Authorization'),
        new Key(config('auth.public_key'), 'RS256')
    );

    $payload = $decoded;

    return response()->json([
        'token' => JWT::encode($payload, config('auth.service.private_key'), 'RS256')
    ]);
});

Route::get('/interface-metadata{route_line}', function (Request $request) {
    $segments = $request->segments();
    $segments[0] = 'interface_metadata';
    $config = config(implode('.', $segments));

    if (!$config) {
        return response()->noContent(404);
    }

    return response()->json($config);
})->where('route_line', '.*');



