<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PresensiController;
use App\Http\Controllers\API\PengumumanController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'presensi'], function(){
    Route::get('/', [PresensiController::class, 'index']);
    Route::get('/{id}', [PresensiController::class, 'show']);
    Route::post('/{id}/record', [PresensiController::class, 'record']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'pengumuman'], function(){
    Route::get('/', [PengumumanController::class, 'index']);
    Route::get('/{id}', [PengumumanController::class, 'show']);
});

Route::middleware('auth:sanctum')->get('user/info', [UserController::class, 'info']);
