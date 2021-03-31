<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Utils\Notes\Notable;

class Projet extends Model
{
    use HasFactory, Notable;

    protected $fillable = ['employeur_id',
                           'statut',
                           'titre',
                           'associations',
                           'numero',
                           'date_creation',
                           'date_debut_recrutement',
                           'date_selection',
                           'nb_candidats',
                           'territoires',
                           'type_emploi'
                          ];

    public function setAssociationsAttribute($value)
    {
        $this->attributes['associations'] = implode(',',$value);
    }

    public function getAssociationsAttribute($value)
    {
        return explode(',',$value);
    }


    public function setTypeEmploiAttribute($value)
    {
        $this->attributes['type_emploi'] = implode(',',$value);
    }

    public function getTypeEmploiAttribute($value)
    {
        return explode(',',$value);
    }

    public function setTerritoiresAttribute($value)
    {
        $this->attributes['territoires'] = implode(',',$value);
    }

    public function getTerritoiresAttribute($value)
    {
        return explode(',',$value);
    }

    public function getDateCreationAttribute($value)
    {
        if(!empty($value)) return \Carbon\Carbon::parse($value)->format('Y-m-d');
        return null;
    }


    /**
     * The news that belong to many candidats.
     */
    public function demandes()
    {
        return $this->hasMany('App\Models\Demande', 'projet_id', 'id');
    }

    /**
     * The news that belong to many candidats.
     */
    public function employeur()
    {
        return $this->hasOne('App\Models\Employeur', 'id', 'employeur_id');
    }

}
