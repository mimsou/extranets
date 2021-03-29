<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = ['projet_id',
                           'employeur_id',
                           'statut',
                           'facturation_horaire',
                           'nb_candidat',
                           'procedure',
                           'date_debut_mandat',
                           'eimt_date_envoi',
                           'eimt_date_accuse_rec',
                           'eimt_date_reception',
                           'eimt_date_echeance',
                           'eimt_numero',
                           'dst_date_envoi',
                           'dst_date_accuse_rec',
                           'dst_date_reception',
                           'dst_date_echeance',
                           'dst_numero',
                           'contact_nom',
                           'contact_prenom',
                           'contact_titre',
                           'contact_email',
                           'contact_phone',
                           'contact_ext',
                           'territoires',
                           'type_emploi',
                           'type',
                           'conv_collective',
                           'rec_categorie',
                           'test_pratique',
                           'bas_salaire',
                           'description_poste',
                           'poste_fonctions',
                           'poste_competences',
                           'autre_information',
                           'annee_exp',
                           'diplome',
                           'langue',
                           'salaire',
                           'lieu_travail',
                           'code_cnp'
                          ];

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


    public function projet(){
        return $this->hasOne('App\Models\Projet', 'id', 'projet_id');
    }

    public function employeur(){
        return $this->hasOne('App\Models\Employeur', 'id', 'employeur_id');
    }

    /**
     * The news that belong to many candidats.
     */
    public function candidats()
    {
        return $this->belongsToMany('App\Models\Candidat', 'demande_candidat', 'demande_id', 'candidat_id', 'id', 'id')->withPivot('statut');
    }

    public function postes($separator = ', '){
        $emplois = \App\Models\Emploi::whereIn('id', $this->type_emploi)->pluck('title')->toArray();
        return implode($separator, $emplois);
    }

}
