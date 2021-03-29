<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Utils\Logs\Loggable;
use App\Classes\Utils\Notes\Notable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Candidat extends Model implements HasMedia
{
    use HasFactory, Notable, Loggable, InteractsWithMedia;

    protected $fillable = [ 'nom',
                            'numero',
                            'statut',
                            'statut_pt',
                            'date_debut_recrutement',
                            'date_selection',
                            'pays_recrutement',
                            'mission_id',
                            'emploi_id',
                            'date_arrive',
                            'date_debut_emploi',
                            'date_fin_emploi',
                            'regroupement_id',
                            'nom_employeur',
                            'com_candidat',
                            'com_recrutement',
                            'com_immigration',
                            'com_bureau_etranger',
                            'dst_date_envoi',
                            'dst_date_accuse_rec',
                            'dst_date_reception',
                            'dst_numero',
                            'permis_date_envoi',
                            'permis_date_reception',
                            'permis_date_echeance',
                            'permis_date_renouvellement',
                            'permis_date_delivrance',
                            // 'date_mandat_immigration',
                            // 'immigration_user_id',
                            'recruteur_id'
                        ];




    public function logFields(){ return ['*']; }


    public function pays(){
        return $this->hasOne('App\Models\Pays', 'id', 'pays_recrutement');
    }

    public function recruteur(){
        return $this->hasOne('App\Models\User', 'id', 'recruteur_id');
    }

    public function regroupement(){
        return $this->hasOne('App\Models\Regroupement', 'id', 'regroupement_id');
    }

    /**
     * The news that belong to many demandes.
     */
    public function demandes()
    {
        return $this->belongsToMany('App\Models\Demande', 'demande_candidat', 'candidat_id', 'demande_id', 'id', 'id')->withPivot('statut');
    }

    /**
     * The news that belong to many demandes.
     */
    public function demandesImmigration()
    {
        // $d_arr = [];

        // foreach ($this->demandes as $key => $d) {
        //     if(Str::contains($d->projet->statut, 'imm_')) array_push($d_arr, $d);
        // }

        // return $d_arr;

        return $this->belongsToMany('App\Models\Demande', 'demande_candidat', 'candidat_id', 'demande_id', 'id', 'id')->where('type','LIKE','immigration')->withPivot('statut');
    }


    /**
     * The news that belong to many demandes.
     */
    public function demandesRecrutement()
    {
        // $d_arr = [];

        // foreach ($this->demandes as $key => $d) {
        //     if(Str::contains($d->projet->statut, 'rec_')) array_push($d_arr, $d);
        // }

        // return $d_arr;
        return $this->belongsToMany('App\Models\Demande', 'demande_candidat', 'candidat_id', 'demande_id', 'id', 'id')->where('type','LIKE','recrutement')->withPivot('statut');
    }


    public function emploi(){
        return $this->hasOne('App\Models\Emploi', 'id', 'emploi_id');
    }


    public function statutIconHTML(){
        switch($this->statut){
            case 'disponible':
                return '<i class="fas fa-check-circle text-success display-5"></i>';
                break;
            case 'en_traitement':
                return '<i class="fas fa-user-clock text-info display-5"></i>';
                break;
            case 'en_emploi':
                return '<i class="fas fa-user-hard-hat display-5"></i>';
                break;
            case 'termine':
                return '<i class="fas fa-check-circle text-grey display-5"></i>';
                break;
            case 'retire':
                return '<i class="fas fa-exclamation-triangle text-warning display-5"></i>';
                break;
            case 'non_recrute':
                return '<i class="fas fa-ban text-danger display-5"></i>';;
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

    /**
     * Register Media Collections
     *
     */
	public function registerMediaCollections(): void {

        $this->addMediaCollection('avatar')
                ->singleFile()
                ->registerMediaConversions(function (Media $media) {
                    $this->addMediaConversion('thumb')
                        ->fit(Manipulations::FIT_FILL, 100, 100)
                        ->sharpen(10)
                        ->performOnCollections('avatar');

                    $this->addMediaConversion('medium')
                        ->width(250)
                        ->sharpen(10)
                        ->performOnCollections('avatar');

                    $this->addMediaConversion('large')
                        ->width(500)
                        ->sharpen(10)
                        ->performOnCollections('avatar');

                    $this->addMediaConversion('xlarge')
                        ->width(1000)
                        ->sharpen(10)
                            ->performOnCollections('avatar');
                });

        $this->addMediaCollection('resources')
                ->registerMediaConversions(function (Media $media) {
                    $this->addMediaConversion('thumb')
                        ->fit(Manipulations::FIT_FILL, 100, 100)
                        ->sharpen(10)
                        ->performOnCollections('resources');

                    $this->addMediaConversion('medium')
                        ->width(250)
                        ->sharpen(10)
                        ->performOnCollections('resources');

                    $this->addMediaConversion('large')
                        ->width(500)
                        ->sharpen(10)
                        ->performOnCollections('resources');

                    $this->addMediaConversion('xlarge')
                        ->width(1000)
                        ->sharpen(10)
                        ->performOnCollections('resources');
                });
    }



}
