<?php

namespace App\Classes\Utils\Notes;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'model_id', 'model_type', 'category', 'message', 'ip'];

    public function user(){
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
}
