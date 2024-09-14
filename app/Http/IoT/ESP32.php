<?php

namespace App\Http\IoT;

use App\Models\LogSensor;
use App\Models\Sensor;
use Illuminate\Support\Facades\Http;

class ESP32
{
    protected String $url = "http://192.168.0.128";

    static function make(){
        return new ESP32();
    }

    function turnOnLamp(int $id){
        $response = Http::get("{$this->url}/lamp/{$id}/1");
        return $response->json();
    }

    function turnOffLamp(int $id){
        $response = Http::get("{$this->url}/lamp/{$id}/0");
        return $response->json();
    }

    function turnOnAllLamp(){
        $response = Http::get("{$this->url}/lamp/turnOnAll");
        $lamp_data = Sensor::where('name', 'like', 'Lamp%')->get();
        foreach ($lamp_data as $lamp) {
            $lamp->update(['state' => 1]);
        }
        return $response->json();
    }

    function turnOffAllLamp(){
        $response = Http::get("{$this->url}/lamp/turnOffAll");
        $lamp_data = Sensor::where('name', 'like', 'Lamp%')->get();
        foreach ($lamp_data as $lamp) {
            $lamp->update(['state' => 0]);
        }
        return $response->json();
    }

    function strobeLamp(){
        $response = Http::get("{$this->url}/lamp/strobe");
        return $response->json();
    }

    function getLumen()
    {
        $response = Http::get("{$this->url}/getLumen");
        $json = $response->json();
        LogSensor::keepTenRecord('ldr');
        LogSensor::create([
            'type' => 'ldr',
            'value' => $json['value'],
            'unit' => 'lumen'
        ]);
        return $json['value'];
    }

    function getTemperature()
    {
        $response = Http::get("{$this->url}/getTemperature");
        $json = $response->json();
        LogSensor::keepTenRecord('temperature');
        LogSensor::create([
            'type' => 'temperature',
            'value' => $json['value'],
            'unit' => '°C'
        ]);
        return $json['value'];
    }

    function getHumidity()
    {
        $response = Http::get("{$this->url}/getHumidity");
        $json = $response->json();
        LogSensor::keepTenRecord('humidity');
        LogSensor::create([
            'type' => 'humidity',
            'value' => $json['value'],
            'unit' => '%'
        ]);
        return $json['value'];
    }
}
