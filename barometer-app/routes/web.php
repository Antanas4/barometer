<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
    ]);
});

Route::get('/{locationName}', [WeatherController::class, 'getWeatherData']);
