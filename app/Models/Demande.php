<?php

namespace App\Models;

use App\Classes\Utils\Notes\Notable;
use App\Classes\Utils\Notify\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Demande
 * @package App\Models
 */
class Demande extends Model
{
    use HasFactory, Notify, Notable;

    /**
     * @var string[]
     */
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
                           'code_cnp',
                           'notes',
                           'completed'
    ];

    /**
     * @param $value
     */
    public function setTypeEmploiAttribute($value)
    {
        $this->attributes['type_emploi'] = implode(',', $value);
    }

    /**
     * @param $value
     * @return false|string[]
     */
    public function getTypeEmploiAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * @param $value
     */
    public function setTerritoiresAttribute($value)
    {
        $this->attributes['territoires'] = implode(',', $value);
    }

    /**
     * @param $value
     * @return false|string[]
     */
    public function getTerritoiresAttribute($value)
    {
        return explode(',', $value);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function projet()
    {
        return $this->hasOne('App\Models\Projet', 'id', 'projet_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employeur()
    {
        return $this->hasOne('App\Models\Employeur', 'id', 'employeur_id');
    }

    /**
     * The news that belong to many candidats.
     */
    public function candidats()
    {
        return $this->belongsToMany('App\Models\Candidat', 'demande_candidat', 'demande_id', 'candidat_id', 'id', 'id')->withPivot('statut');
    }

    /**
     * @param string $separator
     * @return string
     */
    public function postes($separator = ', ')
    {
        $emplois = \App\Models\Emploi::whereIn('id', $this->type_emploi)->pluck('title')->toArray();
        return implode($separator, $emplois);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedUsers()
    {
        return $this->belongsToMany('App\Models\User', 'demande_users');
    }

    /**
     * Get list of todos of Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos()
    {
        return $this->hasMany(Todo::class, 'demande_id', 'id');
    }

    /**
     * Get ToDos of demande
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTodos()
    {
        return $this->todos()->get();
    }

    /**
     * To get the list og todo groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todo_groups(){
        return $this->hasMany(TodoGroup::class,'demande_id','id');
    }

}
