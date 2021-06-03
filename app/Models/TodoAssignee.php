<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoAssignee extends Model
{
    use HasFactory;

    protected $fillable = ['todo_id','user_id'];

    public function user_details(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
