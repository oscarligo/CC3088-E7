<?php

use App\Http\Controllers\EloquentDemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/eloquent-demo', EloquentDemoController::class);
