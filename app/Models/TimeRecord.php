<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet_id',
        'user_id',
        'by_user_id',
        'task_type',
        'description',
        'duration',
        'date_from'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function by_user(){
        return $this->belongsTo(User::class,'by_user_id','id');
    }

    public function projet(){
        return $this->belongsTo(Projet::class,'projet_id','id');
    }
}
