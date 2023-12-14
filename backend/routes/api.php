<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('update', 'update');
    Route::get('get_user/', 'get_user');
    Route::delete('delete_user', 'delete_user');
});

Route::controller(RestaurantController::class)->group(function () {
    Route::post('getall', 'getall');
    Route::post('show', 'show');
    Route::post('create_resto', 'create_resto');
    Route::post('showfirst', 'showfirst');
    Route::post('update', 'update');
    Route::get('create_resto/', 'create_resto');
    Route::post('update_resto/{id}', 'update_resto');
});

Route::controller(ReviewController::class)->group(function () {
    Route::get('show_review', 'show_review');
    Route::post('create_review/{id}', 'create_review');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('orders_getall', 'getall');
    Route::get('orderone/{id}', 'get_one');
    Route::post('create_order', 'create_order');
    Route::put('update_order/{id}', 'update_order');
    Route::delete('delete_orders/{id}', 'delete_order');
});