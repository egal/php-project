<?php

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

// формируется на основе метаданных моделей

\App\egal\Facades\EgalRoute::resource('/posts');
//\Illuminate\Support\Facades\Route::post('/posts', [\App\Http\Controllers\PostController::class, 'custom']);
//\Illuminate\Support\Facades\Route::post('/posts', [\App\egal\APIController::class, 'create']);
//\Illuminate\Support\Facades\Route::put('/posts', [\App\egal\APIController::class, 'update']);
use Illuminate\Support\Facades\Route;

//Route::put('/posts/{post}/update', [\App\egal\APIController::class, 'update']);