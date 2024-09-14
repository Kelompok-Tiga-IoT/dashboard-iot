<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSensor extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'value', 'unit'];

    public static function keepTenRecord(string $type): void
    {
        $logs = LogSensor::where('type', $type)->get();
        if($logs->count() > 10){
            $toBeKeep = $logs->sortByDesc('created_at')->take(10);
            foreach ($logs as $log) {
                if(!$toBeKeep->contains($log)){
                    $log->delete();
                }
            }
        }
    }
}
