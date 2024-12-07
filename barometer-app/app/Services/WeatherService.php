<?php

namespace App\Services;

use App\Models\LocationWeather;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WeatherService
{
    public function getWeatherData(string $locationName)
    {
        $lastWeatherRecord = $this->getLastWeatherRecord($locationName);

        if ($this->shouldFetchNewData($lastWeatherRecord)) {
            $newWeatherData = $this->fetchWeatherData($locationName);
            $this->saveWeatherData($locationName, $newWeatherData);
            $lastWeatherRecord = $this->getLastWeatherRecord($locationName);
        }

        return $lastWeatherRecord;
    }

    private function shouldFetchNewData(?LocationWeather $lastWeatherRecord): bool
    {
        return !$lastWeatherRecord || abs(Carbon::now()->diffInHours($lastWeatherRecord->recordTimestamp))>= 1;
    }

    private function fetchWeatherData(string $locationName): array
    {
        $coordinates = $this->getCoordinates($locationName);
        $pressure = $this->fetchPressureFromAPI($coordinates);

        return [
            'pressure' => $pressure,
            'coordinates' => $coordinates,
        ];
    }

    public function getCoordinates(string $locationName): array
    {
        $coordinates = config("locations.$locationName");

        if (!$coordinates) {
            throw new \InvalidArgumentException("Coordinates for $locationName not found.");
        }

        return $coordinates;
    }

    private function fetchPressureFromAPI(array $coordinates): int
    {
        // $apiKey = env('OPENWEATHERMAP_API_KEY');
        //I know that it should not be hardcoded but something was wrong with my .env file
        $apiKey='73c157afcb476df0b4033f2a4ebb81df';

        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful() && isset($response['main']['pressure'])) {
            return $response['main']['pressure'];
        }

        throw new \RuntimeException('Failed to fetch pressure data.');
    }

    private function saveWeatherData(string $locationName, array $weatherData)
    {
        $lastWeatherRecord = $this->getLastWeatherRecord($locationName);
        $pressureRising = $lastWeatherRecord
            ? $weatherData['pressure'] > $lastWeatherRecord->pressure
            : false;

        LocationWeather::create([
            'locationName' => $locationName,
            'latitude' => $weatherData['coordinates']['lat'],
            'longitude' => $weatherData['coordinates']['lon'],
            'pressure' => $weatherData['pressure'],
            'pressureRising' => $pressureRising,
            'recordTimestamp' => Carbon::now(),
        ]);
    }

    private function getLastWeatherRecord(string $locationName): ?LocationWeather
    {
        return LocationWeather::where('locationName', $locationName)
            ->latest('recordTimestamp')
            ->first();
    }
}
