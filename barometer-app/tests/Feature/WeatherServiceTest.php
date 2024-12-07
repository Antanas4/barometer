<?php
namespace Tests\Feature;

use Config;
use Tests\TestCase;
use App\Services\WeatherService;
use InvalidArgumentException;

class WeatherServiceTest extends TestCase
{
    public function test_getCoordinates_returns_valid_coordinates()
    {
        Config::set('locations.Vilnius', ['lat' => 54.6892, 'lon' => 25.2798]);
        $weatherService = new WeatherService();
        $coordinates = $weatherService->getCoordinates('Vilnius');
        $this->assertEquals(['lat' => 54.6892, 'lon' => 25.2798], $coordinates);
    }

    public function test_getCoordinates_returns_exception()
    {
        $weatherService = new WeatherService();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Coordinates for NonExistingLocation not found.');

        $weatherService->getCoordinates('NonExistingLocation');
    }
}
