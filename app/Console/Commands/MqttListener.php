<?php

namespace App\Console\Commands;

use App\Mqtt\Humidity;
use App\Mqtt\Lamp;
use App\Mqtt\LDR;
use App\Mqtt\Temperature;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class MqttListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mqtt-listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \ReflectionException
     */

    public function handle()
    {
        $sensors = [
            Humidity::class,
            Temperature::class,
            Lamp::class,
            LDR::class
        ];

        $mqtt = MQTT::connection();

        foreach ($sensors as $sensor) {
            try {
                $mqtt->subscribe(topicFilter: $sensor::$topic, callback: fn($topic, $message) => $sensor::handle($topic, $message));
            } catch (\Exception $e) {
                $this->info($e->getMessage());
                $mqtt->interrupt();
            }
        }

        try {
            $mqtt->loop(true);
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            $mqtt->interrupt();
        }
    }
}
