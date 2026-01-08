<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user',
], static function() {
    Route::post('register', [UserController::class, 'register'])->name('user.register');
});

