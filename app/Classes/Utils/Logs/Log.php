<?php

namespace App\Classes\Utils\Logs;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'model_id', 'model_type', 'category', 'message'];

    public function user(){
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
}
