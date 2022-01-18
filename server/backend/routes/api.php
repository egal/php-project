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

\Illuminate\Support\Facades\Route::post('/posts', [\App\Http\Controllers\PostController::class, 'custom']);