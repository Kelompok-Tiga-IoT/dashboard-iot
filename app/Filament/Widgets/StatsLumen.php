<?php

namespace App\Filament\Widgets;

use App\Http\IoT\ESP32;
use App\Models\LogSensor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsLumen extends BaseWidget
{
    protected static ?string $pollingInterval = '2s';
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Lumen', ESP32::make()->getLumen())
                ->chart(LogSensor::where('type', 'ldr')->latest()->limit(20)->get()->pluck('value')->toArray())
                ->color('success')
                ->icon('heroicon-o-light-bulb'),
            Stat::make('Temperature', ESP32::make()->getTemperature() . " °C")
                ->chart(LogSensor::where('type', 'temperature')->latest()->limit(20)->get()->pluck('value')->toArray())
                ->color('danger')
                ->icon('zondicon-thermometer'),
            Stat::make('Humidity', ESP32::make()->getHumidity() . " %")
                ->chart(LogSensor::where('type', 'humidity')->latest()->limit(20)->get()->pluck('value')->toArray())
                ->color('primary')
                ->icon('bi-droplet-fill'),
        ];
    }

    public static function canView(): bool
    {
        $whitelist = "admin/sensors*";

        return request()->is($whitelist);
    }
}
