<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'App\Http\Controllers\Api\UserController@store');
Route::post('/login', 'App\Http\Controllers\Api\Auth\AuthController@login')->name('login');

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::delete('/logout', 'App\Http\Controllers\Api\Auth\AuthController@logout');
        Route::apiResource('/users', 'App\Http\Controllers\Api\UserController');
    });

Route::apiResource('/user-invitations', 'App\Http\Controllers\Api\Auth\UserInvitationController')->except(['show', 'update']);
Route::apiResource('/roles', 'App\Http\Controllers\Api\RoleController')->except('show');

// Variations and Options
Route::apiResource('/variations', 'App\Http\Controllers\Api\VariationController')->only(['index', 'store', 'destroy']);
Route::apiResource('/variations.options', 'App\Http\Controllers\Api\VariationOptionController')->only(['index', 'store']);
Route::patch('/variations/{variation}/options', 'App\Http\Controllers\Api\VariationOptionController@update');
Route::delete('/variations/{variation}/options', 'App\Http\Controllers\Api\VariationOptionController@destroy');

// Product and Product Variation
