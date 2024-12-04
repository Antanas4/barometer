<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('location_weather', function (Blueprint $table) {
            $table->id();
            $table->string('location_name'); 
            $table->decimal('latitude', 10, 6); 
            $table->decimal('longitude', 10, 6); 
            $table->decimal('pressure', 8, 2); 
            $table->boolean('pressure_rising'); 
            $table->timestamp('record_timestamp'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_weather');
    }
};