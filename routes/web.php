<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AttendanceController::class, 'index'])
    ->name('home.attendance');

Route::post('/', [AttendanceController::class, 'store'])
    ->name('log.attendance');