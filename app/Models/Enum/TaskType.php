<?php

namespace App\Models\Enum;

class TaskType
{
    public const EIMT = 'EIMT';
    public const DST = 'DST';
    public const PT = 'PT';
    
    public static function all():array{
        return [
            self::EIMT,
            self::DST,
            self::PT,
        ];
    }
}