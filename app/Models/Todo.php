<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Todo
 * @package App\Models
 */
class Todo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['projet_id', 'group_id', 'demande_id', 'to_do', 'status', 'created_by'];

    /**
     * Get todos
     *
     * @param $projectId
     * @param $demandeId
     * @return mixed
     */
    public static function getTodos($projectId, $demandeId)
    {
        return self::where(['projet_id' => $projectId, 'demande_id' => $demandeId])->orderBy('order')->get();
    }

    /**
     * Get max order in order to sort todo
     *
     * @param $projetId
     * @param $demandeId
     * @return int
     */
    public static function getMaxOrder($projetId, $demandeId, $groupId)
    {
        $record = self::where(['projet_id' => $projetId, 'demande_id' => $demandeId,'group_id'=>$groupId])->orderBy('order', 'desc')->first();
        if ($record != null) {
            return $record->order;
        } else {
            return 0;
        }
    }

    public function assigned_user(){
        return $this->hasMany(TodoAssignee::class,'todo_id','id');
    }
}
