<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Utils\Notes\Notable;

class Projet extends Model
{
    use HasFactory, Notable;

    protected $fillable = ['employeur_id',
                           'responsable_id',
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
        $this->attributes['associations'] = implode(',', $value);
    }

    public function getAssociationsAttribute($value)
    {
        return explode(' | ', $value);
    }


    public function setTypeEmploiAttribute($value)
    {
        $this->attributes['type_emploi'] = implode(' | ', $value);
    }

    public function getTypeEmploiAttribute($value)
    {
        return explode(',', $value);
    }

    public function setTerritoiresAttribute($value)
    {
        $this->attributes['territoires'] = implode(',', $value);
    }

    public function getTerritoiresAttribute($value)
    {
        return explode(',', $value);
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


    /**
     * The news that belong to many candidats.
     */
    public function responsable()
    {
        return $this->hasOne('App\Models\User', 'id', 'responsable_id');
    }


    public function childRowHtml($statut_du_dossier = null, $isCompletedChecked = false, $isHourlyChecked = false)
    {
        $projet = $this;
        return view('admin.projets.partials._childrow', compact('projet', 'statut_du_dossier',
            'isCompletedChecked','isHourlyChecked'));
    }

    public static function getProjetDeType()
    {
        return ['new_projet' => __('new_projet'),
                'Immigration' => [
                    'imm_eimt_dst_pt' => __('imm_eimt_dst_pt'),
                    'imm_eimt_dst_pt_ave' => __('imm_eimt_dst_pt_ave'),
                    'imm_pt' => __('imm_pt'),
                    'imm_pt_ave' => __('imm_pt_ave'),
                    'imm_conf_pt' => __('imm_conf_pt'),
                    'imm_individu' => __('imm_individu'),
                    'imm_autre' => __('imm_autre')],
                'Recrutement' => [
                    'rec_mission_dedie' => __('rec_mission_dedie'),
                    'rec_mission_partagee' => __('rec_mission_partagee'),
                    'rec_mission_partenaire' => __('rec_mission_partenaire'),
                    'rec_garantie' => __('rec_garantie'),
                    'rec_cdts_qualifies' => __('rec_cdts_qualifies'),
                ],
                'acc_accueil' => __('acc_accueil')
        ];
    }


}
