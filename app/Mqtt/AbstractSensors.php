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

    static function receive(string $topic): array
    {
        $data = [];
        $retrieve = MQTT::connection();
        $retrieve->subscribe($topic, function ($topic, $message) use (&$data) {
            $data = json_decode($message, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $data = [];
            }
        });

        return $data;
    }

    abstract static function process(string $topic, array $data);
}
