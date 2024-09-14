<?php

namespace App\Filament\Resources\SensorResource\Pages;

use App\Filament\Resources\SensorResource;
use App\Filament\Widgets\StatsLumen;
use App\Http\IoT\ESP32;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ListSensors extends ListRecords
{
    protected static string $resource = SensorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Turn On All Lamp')->color('success')->action(fn() => ESP32::make()->turnOnAllLamp()),
            Actions\Action::make('Turn Off All Lamp')->color('danger')->action(fn() => ESP32::make()->turnOffAllLamp()),
            Actions\Action::make('Strobe Lamp')->color('warning')->action(fn() => ESP32::make()->strobeLamp()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsLumen::make(),
        ];
    }
}
