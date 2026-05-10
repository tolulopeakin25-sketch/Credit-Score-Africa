<?php

use App\Http\Controllers\Api\CreditProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('credit-profiles', [CreditProfileController::class, 'index']);
    Route::post('credit-profiles', [CreditProfileController::class, 'store']);
    Route::get('credit-profiles/{credit_profile}', [CreditProfileController::class, 'show']);
    Route::post('credit-profiles/{credit_profile}/bureau', [CreditProfileController::class, 'updateBureau']);
    Route::get('credit-profiles/{credit_profile}/score', [CreditProfileController::class, 'score']);
});
