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
        

        if (!$lastWeatherRecord || Carbon::now()->diffInHours($lastWeatherRecord->recordTimestamp) >= 1) {
            $this->saveWeatherData($locationName);
            $lastWeatherRecord = $this->getLastWeatherRecord($locationName);
        }

        return $lastWeatherRecord;
    }

    private function saveWeatherData(string $locationName)
    {
        $coordinates = config("locations.$locationName");
        $currentPressure = $this->getCurrentPressure($locationName);
        $lastWeatherRecord = $this->getLastWeatherRecord($locationName);
        $pressureRising = false;

        if (!$coordinates) {
            throw new \Exception("Coordinates for $locationName not found.");
        }

        if ($lastWeatherRecord){
            $pressureRising = $currentPressure > $lastWeatherRecord->pressure;
        }
        
        \Log::info("Saving data for $locationName with coordinates:", $coordinates);

        LocationWeather::create([
            'locationName' => $locationName,
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lon'],
            'pressure' => $currentPressure,
            'pressureRising' => $pressureRising,
            'recordTimestamp' => Carbon::now(),
        ]);
    }

    private function getLastWeatherRecord(string $locationName)
    {
        return LocationWeather::where('locationName', $locationName)
            ->orderBy('recordTimestamp', 'desc')
            ->first();
    }

    private function getCurrentPressure(string $locationName)
    {
        // $apiKey = env('OPENWEATHERMAP_API_KEY');
        //I know that it should not be hardcoded but something was wrong with my .env file
        $apiKey='73c157afcb476df0b4033f2a4ebb81df';
        $coordinates = config("locations.$locationName", config('locations.Vilnius'));

        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful() && isset($response['main']['pressure'])) {
            return $response['main']['pressure'];
        }
    
        throw new \Exception("Failed to fetch pressure data for $locationName.");
    }
}