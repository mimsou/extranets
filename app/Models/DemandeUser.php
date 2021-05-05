<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Projet;

/**
 * Class DemandeUser
 * @package App\Models
 */
class DemandeUser extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['demande_id', 'user_id'];

    /**
     * User to whom this belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
