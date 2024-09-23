<?php

namespace App\Mqtt;

use PhpMqtt\Client\Facades\MQTT;

abstract class AbstractSensors
{
    public static string $topic;
    public array $data;
    public static function handle(string $topic, string $message): void
    {
        $data = json_decode($message, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = [];
        }
        static::process($topic, $data);
    }

    static function send(string $topic, array $data): void
    {
        MQTT::publish($topic, json_encode($data));
    }

    abstract static function process(string $topic, array $data);
}
