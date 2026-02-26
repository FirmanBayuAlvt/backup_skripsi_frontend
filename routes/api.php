<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PredictionController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {
    Route::get('/overview', [DashboardController::class, 'getOverviewData']);
    Route::get('/pen-analytics', [DashboardController::class, 'getPenAnalytics']);
});

Route::prefix('predictions')->group(function () {
    Route::get('/history', [PredictionController::class, 'getPredictionHistory']);
});
