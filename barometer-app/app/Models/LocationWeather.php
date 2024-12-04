<?php

use Carbon\Carbon;

class LocationWeather
{
    private $locationName;
    private $latitude;
    private $longitude; 
    private $pressure;
    private $pressureRising;
    private $recordTimestamp;


    public function __construct(
        string $locationName, 
        float $latitude, 
        float $longitude, 
        float $pressure, 
        bool $pressureRising, 
        string $recordTimestamp
    ) {
        $this->locationName = $locationName;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->pressure = $pressure;
        $this->pressureRising = $pressureRising;
        $this->recordTimestamp = Carbon::parse($recordTimestamp); 
    }

    public function getLocation(): string
    {
        return $this->locationName; 
    }

    public function getPressure(): float
    {
        return $this->pressure;
    }

    public function getPressureRising(): bool
    {
        return $this->pressureRising;
    }

    public function getRecordTimestamp(): Carbon
    {
        return $this->recordTimestamp;
    }

    // Setters
    public function setLocation(string $locationName): void
    {
        $this->locationName = $locationName;
    }

    public function setPressure(float $pressure): void
    {
        $this->pressure = $pressure;
    }

    public function setPressureRising(bool $pressureRising): void
    {
        $this->pressureRising = $pressureRising;
    }

    public function setRecordTimestamp(string $recordTimestamp): void
    {
        $this->recordTimestamp = Carbon::parse($recordTimestamp);
    }
}