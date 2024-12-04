<?php
namespace App\Services;

use App\Models\LocationWeather;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherData(string $location)
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        $coordinates = config("locations.$location", config('locations.Vilnius'));

        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json()['main']['pressure'];
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
