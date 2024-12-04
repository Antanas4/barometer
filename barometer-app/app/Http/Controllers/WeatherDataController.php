<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherDataController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeatherData(Request $request, string $locationName)
    {
        $weatherData = $this->weatherService->getWeatherData($locationName);

        return response()->json(['weather_data' => $weatherData]);
    }
}