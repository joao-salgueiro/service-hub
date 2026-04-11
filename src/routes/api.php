<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProviderRegionController;
use App\Http\Controllers\Api\BookingController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Regiões de atendimento do provider
    Route::post('/provider/regions', [ProviderRegionController::class, 'store']);
    Route::get('/provider/regions', [ProviderRegionController::class, 'index']);

    // Solicitações de serviço para o provider (acompanhamento)
    Route::get('/provider/bookings', [BookingController::class, 'index']);
    Route::post('/provider/bookings/{id}/accept', [BookingController::class, 'accept']);
    Route::post('/provider/bookings/{id}/reject', [BookingController::class, 'reject']);

    // Perfil do prestador
    Route::get('/provider/profile', [\App\Http\Controllers\Api\ProviderProfileController::class, 'show']);
    Route::post('/provider/profile', [\App\Http\Controllers\Api\ProviderProfileController::class, 'update']);
});