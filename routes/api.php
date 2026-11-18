<?php

use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MeteranController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\RuangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('jwt')->group(function () {
    Route::apiResource('lokasi', LokasiController::class);
    Route::apiResource('ruang', RuangController::class);
    Route::apiResource('perangkat', PerangkatController::class);
    Route::apiResource('meteran', MeteranController::class);
});
