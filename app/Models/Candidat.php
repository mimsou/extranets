<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;


    public function statutIconHTML(){
        switch($this->statut){
            case 'disponible':
                return '<h4><i class="fas fa-check-circle text-success display-5"></i></h4>';
                break;
            case 'en_traitement':
                return '<h4><i class="fas fa-user-clock text-info display-5"></i></h4>';
                break;
            case 'en_emploi':
                return '<h4><i class="fas fa-user-hard-hat display-5"></i></h4>';
                break;
            case 'termine':
                return '<h4><i class="fas fa-check-circle text-grey display-5"></i></h4>';
                break;
            case 'retire':
                return '<h4><i class="fas fa-exclamation-triangle text-warning display-5"></i></h4>';
                break;
            case 'non_recrute':
                return '<h4><i class="fas fa-ban text-danger display-5"></i></h4>';;
                break;
        }
    }

    public function statutReadable(){
        switch($this->statut){
            case 'en_traitement':
                return 'En traitement';
                break;
            case 'en_emploi':
                return 'En emploi';
                break;
            case 'termine':
                return 'Terminé';
                break;
            case 'retire':
                return 'Retiré';
                break;
            case 'non_recrute':
                return 'Non recruté';
                break;
        }

        return ucfirst($this->statut);
    }
}
