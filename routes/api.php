<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// O middleware em questão verifica se o usuário possui o token após fazer login, para a sessão do usuário se manter
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
