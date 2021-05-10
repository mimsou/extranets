<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['projet_id','demande_id','to_do','status','created_by'];

    public static function getTodos($projectId, $demandeId){
        return self::where(['projet_id'=>$projectId,'demande_id'=>$demandeId])->orderBy('order')->get();
    }

    public static function getMaxOrder($projetId, $demandeId){
        $record = self::where(['projet_id'=>$projetId,'demande_id'=>$demandeId])->orderBy('order','desc')->first();
        if($record != null){
            return $record->order;
        }else{
            return 0;
        }
    }
}
