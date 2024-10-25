<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'App\Http\Controllers\Api\UserController@store');
Route::post('/user-invitations', 'App\Http\Controllers\Api\UserInvitationController@store');
