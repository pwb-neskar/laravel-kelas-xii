<?php

use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Baca data film: terbuka untuk umum
Route::apiResource('movie', MovieController::class)->only(['index', 'show']);

// Tambah, ubah, hapus film: hanya admin yang login dengan token Sanctum
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('movie', MovieController::class)->except(['index', 'show']);
});