<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [UserController::class, 'store'])->name('api.register');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
