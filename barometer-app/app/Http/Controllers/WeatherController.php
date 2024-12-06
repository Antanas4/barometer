<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeatherData(Request $request, string $locationName)
    {
        try {
            $locationWeather = $this->weatherService->getWeatherData($locationName);
            return response()->json([
                'success' => true,
                'data' => $locationWeather
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500); 
        }
    }
}