<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LocationWeather extends Model
{
    protected $table = 'location_weather';

    protected $fillable = ['locationName', 'latitude', 'longitude', 'pressure', 'pressureRising', 'recordTimestamp'];

    public $timestamps = false;

    public function setRecordTimestampAttribute($value): void
    {
        $this->attributes['recordTimestamp'] = Carbon::parse($value);
    }}
