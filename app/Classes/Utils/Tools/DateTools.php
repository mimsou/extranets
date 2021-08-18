<?php

namespace App\Classes\Utils\Tools;

use Carbon\Carbon;

class DateTools
{

    public static function checkDateBeforeAfter($event_date, $event_date_end): bool
    {
        if (isset($event_date) && isset($event_date_end)) {
            try {
                if (Carbon::parse($event_date)->gt(Carbon::parse($event_date_end))) {
                    return false;
                }
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        }
        return true;
    }

}