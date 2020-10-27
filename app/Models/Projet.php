<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = ['employeur_id',
                           'statut',
                           'titre',
                           'numero',
                           'date_creation',
                           'date_debut_recrutement',
                           'nb_candidats',
                           'type_emploi'
                          ];

    public function setTypeEmploiAttribute($value)
    {
        $this->attributes['type_emploi'] = implode(',',$value);
    }

    public function getTypeEmploiAttribute($value)
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
    public function candidats()
    {
        return $this->belongsToMany('App\Models\Candidat', 'projet_candidat', 'projet_id', 'candidat_id', 'id', 'id');
    }

    /**
     * The news that belong to many candidats.
     */
    public function employeur()
    {
        return $this->hasOne('App\Models\Employeur', 'id', 'employeur_id');
    }

}
