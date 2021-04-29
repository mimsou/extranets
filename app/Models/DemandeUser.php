<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeUser extends Model
{
    use HasFactory;

    protected $fillable = ['demande_id', 'user_id']
}
