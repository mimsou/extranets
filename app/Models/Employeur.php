<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Utils\Notes\Notable;
use App\Classes\Utils\Logs\Loggable;

class Employeur extends Model
{
    use HasFactory, Notable, Loggable;

    protected $fillable = ['nom',
                           'regroupement_id',
                           'statut',
                           'adresse',
                           'adresse_2',
                           'ville',
                           'province',
                           'pays_id',
                           'zip',
                           'contact_nom',
                           'contact_prenom',
                           'contact_titre',
                           'contact_email',
                           'contact_phone',
                           'contact_ext',
                           'has_secondary_contact',
                           'secondary_contact_nom',
                           'secondary_contact_prenom',
                           'secondary_contact_titre',
                           'secondary_contact_email',
                           'secondary_contact_phone',
                           'secondary_contact_ext',
                           'has_third_contact',
                           'third_contact_nom',
                           'third_contact_prenom',
                           'third_contact_titre',
                           'third_contact_email',
                           'third_contact_phone',
                           'third_contact_ext',
                          ];


    public function logFields(){ return ['*']; }


    public function pays(){
        return $this->hasOne('App\Models\Pays', 'id', 'pays_id');
    }


    public function regroupement(){
        return $this->hasOne('App\Models\Regroupement', 'id', 'regroupement_id');
    }

    public function projets(){
        return $this->hasMany('App\Models\Projet');
    }

    public function demandes(){
        return $this->hasMany('App\Models\Demande');
    }


    public function statutIconHTML(){
        switch($this->statut){
            case 'actif':
                return '<i class="fas fa-check-circle text-success display-5"></i>';
                break;
            case 'inactif':
                return '<i class="fas fa-ban text-danger display-5"></i>';
                break;
        }

        return 'NA';
    }
}
