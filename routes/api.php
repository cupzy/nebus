<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\VerifyApiToken;
use Illuminate\Support\Facades\Route;

Route::middleware(VerifyApiToken::class)->group(function () {
    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'show'])->whereNumber('id');
    Route::get('/buildings', [BuildingController::class, 'index']);
});
