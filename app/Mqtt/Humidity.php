<?php

namespace App\Mqtt;

use App\Mqtt\AbstractSensors;

class Humidity
{
    public static string $topic = 'iot/sensor/dht22/humidity';
     public static function process(string $topic, array $data)
    {
        echo 'Humidity: ' . $data['value'] . PHP_EOL;
    }
}
