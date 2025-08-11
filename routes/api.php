<?php

use App\Http\Controllers\V1\{BalanceController, EventController};
use Illuminate\Support\Facades\Route;

Route::name('v1.')->group(function () {
    Route::controller(BalanceController::class)->prefix('balance')->name('balance.')
        ->group(function () {
            Route::get('', 'show')->name('show');
        });

    Route::controller(EventController::class)->prefix('event')->name('event.')
        ->group(function () {
            Route::post('', 'store')->name('store');
        });
});
