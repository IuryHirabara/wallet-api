<?php

use App\Http\Controllers\V1\{BalanceController};
use Illuminate\Support\Facades\Route;

Route::name('v1.')->group(function () {
    Route::controller(BalanceController::class)->prefix('balance')->name('balance.')
        ->group(function () {
            Route::get('', 'show')->name('show');
        });
});
