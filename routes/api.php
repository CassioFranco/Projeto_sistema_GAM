<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ReportController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::patch('/colaboradores/{id}/localizacao', [CollaboratorController::class, 'updateLocation']);
    Route::get('/colaboradores/{id}', [CollaboratorController::class, 'show']);
    Route::get('/colaboradores/{id}/historico', [CollaboratorController::class, 'history']);

    Route::post('/ativos', [AssetController::class, 'store']);

    Route::post('/transferencia', [TransferController::class, 'transfer']);

    Route::get('/relatorios', [ReportController::class, 'reports']);
});