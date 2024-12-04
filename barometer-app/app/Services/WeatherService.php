<?php
namespace App\Services;

use App\Models\LocationWeather;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherData(string $location)
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather?lat=54.687157&lon=25.279652&appid=73c157afcb476df0b4033f2a4ebb81df&units=metric', [
            'lat' => '54.687157',
            'lon' => '25.279652',
            'appid' => '73c157afcb476df0b4033f2a4ebb81df',
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $data = $response->json(); 
            $pressure = $data['main']['pressure'];
            return $pressure;
        }

        Log::error("OpenWeatherMap request failed", ['response' => $response->body()]);
        return response()->json(['error' => 'Unable to fetch weather data'], 500);
    }

    private function storeWeatherData(array $data)
    {
        $weatherData = new WeatherData();
        $weatherData->location = $data['city']['name'];
        $weatherData->pressure = $data['list'][0]['main']['pressure'];
        $weatherData->temperature = $data['list'][0]['main']['temp'];
        $weatherData->humidity = $data['list'][0]['main']['humidity'];
        $weatherData->recorded_at = now();
        $weatherData->save();

        return $weatherData;
    }

    public function calculatePressureTrend(WeatherData $current, WeatherData $previous)
    {
        return $current->pressure > $previous->pressure ? 'rising' : 'falling';
    }
}
