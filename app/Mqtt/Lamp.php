<?php

namespace App\Mqtt;

use PhpMqtt\Client\Facades\MQTT;

class Lamp extends AbstractSensors
{
    /*
     * iot/sensor/lamp/+
     * iot/sensor/lamp/1
     */
    public static string $topic = 'iot/sensor/lamp/+';


    static function process(string $topic, array $data)
    {
        echo $topic . json_encode($data) . PHP_EOL;
    }

    static function turnOn($lamp_id): void
    {
        self::send('iot/sensor/lamp/' . $lamp_id, ['action' => 'on']);
    }

    static function turnOff($lamp_id): void
    {
        self::send('iot/sensor/lamp/' . $lamp_id, ['action' => 'off']);
    }

    static function getStatus($lamp_id): array
    {
        return self::receive('iot/sensor/lamp/' . $lamp_id);
    }
}
