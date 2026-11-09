<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\FinePaymentController;

// Endpoint publik: hanya login
Route::post('/login', [AuthController::class, 'login']);

// Endpoint yang dilindungi token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('members', MemberController::class);
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('publishers', PublisherController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('loans', LoanController::class);
    Route::apiResource('returns', BookReturnController::class)->only(['index', 'show', 'store']);
    Route::apiResource('fine-payments', FinePaymentController::class)->only(['index', 'show', 'store']);
});
