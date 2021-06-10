<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoGroup extends Model
{
    use HasFactory;
    protected $fillable = ['group_name','status','demande_id','projet_id','sort_order','todo_title'];

    public function todos(){
        return $this->hasMany(Todo::class,'group_id','id');
    }

    public static function getCompletedTodos($projetId,$demandeId){
        $model = new self;
        $model = $model->newQuery()->with(['todos'=>function($query){
            return $query->where(['status'=>1]);
        }])->where(['demande_id'=>$demandeId,'projet_id'=>$projetId])->get();
        $records = $model->map(function($group){
            return $group->todos->count();
        })->sum();
        return $records;
    }

    public static function getTotalTodos($projetId,$demandeId){
        $model = new self;
        $model = $model->newQuery()->with(['todos'])->where(['demande_id'=>$demandeId,'projet_id'=>$projetId])->get();
        $records = $model->map(function($group){
            return $group->todos->count();
        })->sum();
        return $records;
    }
}
