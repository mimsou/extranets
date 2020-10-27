<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeur extends Model
{
    use HasFactory;

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
                           'contact_email',
                           'contact_phone'
                          ];


    public function pays(){
        return $this->hasOne('App\Models\Pays', 'id', 'pays_id');
    }


    public function regroupement(){
        return $this->hasOne('App\Models\Regroupement', 'id', 'regroupement_id');
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
