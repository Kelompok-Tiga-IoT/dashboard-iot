<?php

namespace App\Mqtt;

class Temperature
{
    public static string $topic = 'iot/sensor/dht22/temperature';

    public static function process(string $topic, array $data): void
    {
        echo 'Temperature: ' . $data['value'] . PHP_EOL;
    }
}
