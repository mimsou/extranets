<?php

namespace App\Classes\Utils\Tools;

class TimeTools
{
    public static function hoursToFloat(string $time):float{
        list($hours, $minutes) = explode(':', $time);
        $minutes = round($minutes * 10000 / 60,4);
        $hours = $hours + $minutes/10000;
        return floatval($hours);
    }

    public static function floatToHours(float $time):string{
        list($hours) = explode('.', $time);
        $minutes = round(($time - $hours) * 60,0);
        if($hours < 10){
            $hours = '0'.$hours;
        }
        if($minutes < 10){
            $minutes = '0'.$minutes;
        }
        return $hours.'h'.$minutes;
    }
}