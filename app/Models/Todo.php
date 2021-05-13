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
    protected $fillable = ['projet_id', 'demande_id', 'to_do', 'status', 'created_by'];

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
    public static function getMaxOrder($projetId, $demandeId)
    {
        $record = self::where(['projet_id' => $projetId, 'demande_id' => $demandeId])->orderBy('order', 'desc')->first();
        if ($record != null) {
            return $record->order;
        } else {
            return 0;
        }
    }
}
