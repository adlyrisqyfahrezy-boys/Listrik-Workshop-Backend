<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MeteranController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\RuangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('jwt')->get('me', [AuthController::class, 'me']);
Route::middleware('jwt')->post('refresh', [AuthController::class, 'refresh']);

Route::middleware('jwt')->group(function () {
    Route::apiResource('lokasi', LokasiController::class);
    Route::apiResource('ruang', RuangController::class);
    Route::apiResource('perangkat', PerangkatController::class);
    Route::apiResource('meteran', MeteranController::class);
});
