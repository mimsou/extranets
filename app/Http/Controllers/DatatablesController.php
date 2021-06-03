<?php

namespace App\Http\Controllers;

use DB;
use Str;
use App\Models\Candidat;
use App\Models\Emploi;
use App\Models\Employeur;
use App\Models\Mission;
use App\Models\Pays;
use App\Models\Projet;
use App\Models\Regroupement;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCandidats()
    {
        return Datatables::of(Candidat::with('pays')->with('recruteur')->with('emploi')->with('regroupement'))
                        ->editColumn('statut', function(Candidat $c){
                            return '<h5>'.$c->statutIconHTML() . '<small class="pl-2">'.$c->statutReadable().'</small></h5>';
                        })
                        ->editColumn('nom', function(Candidat $c){
                            return '<a href="'.action('CandidatController@edit', $c->id).'"><h5>'.$c->nom . '</h5></a>';
                        })
                        ->addColumn('pays', function (Candidat $c) {
                            if(!is_null($c->pays)) return $c->pays->title;
                            return ' -- ';
                        })
                        ->addColumn('recruteur', function (Candidat $c) {
                            if(!is_null($c->recruteur)) return $c->recruteur->firstname;
                            return ' -- ';
                        })
                        ->addColumn('emploi', function (Candidat $c) {
                            if(!is_null($c->emploi)) return $c->emploi->title;
                            return ' -- ';
                        })
                        ->addColumn('regroupement', function (Candidat $c) {
                            if(!is_null($c->regroupement)) return $c->regroupement->title;
                            return ' -- ';
                        })
                        ->addColumn('mission', function (Candidat $c) {
                            if(!is_null($c->mission)) return $c->mission->numero;
                            return ' -- ';
                        })
                        ->editColumn('updated_at', function(Candidat $c){
                            return $c->updated_at->diffForHumans() .'<br><small>'.$c->updated_at.'</small>';
                        })
                        ->addColumn('action', function(Candidat $c){
                            $delete = '';
                            if($c->demandes()->count() == 0)
                                $delete = '<button class="btn btn-sm btn-danger delete_candidate" data-candidat="'.$c->id.'"><i class="fas fa-trash"></i></button>';

                            return '<a href="'.action('CandidatController@edit', $c->id).'" class="btn btn-sm btn-primary mr-2"><i class="fas fa-user-edit"></i></a>' . $delete;
                        })
                        ->make(true);
    }


    public function getProjets($personne = null,$type_de_projet = null, $employeur = null, $statut_du_dossier = null,
                               $isCompletedChecked = false, $isHourlyChecked = false){
        $projets = DB::table('projets')
                     ->select(['projets.*', 'employeurs.nom','demandes.projet_id','demandes.completed',
                               'demandes.employeur_id as demande_employeur_id'])
                     ->join('employeurs', 'employeurs.id', '=', 'projets.employeur_id')
                     ->leftjoin('users', 'users.id', '=', 'projets.responsable_id')
                     ->leftJoin('demandes','demandes.projet_id','=','projets.id');
        if($type_de_projet != 'ALL' && $type_de_projet != null){
            if(in_array($type_de_projet,['Immigration','new_projet','Recrutement'])){
                $statut = \App\Models\Projet::getProjetDeType();
                $projets->whereIn('projets.statut',array_keys($statut[$type_de_projet]));
            }else{
                $projets->where('projets.statut',$type_de_projet);
            }
        }

        if($employeur != 'ALL' && $employeur != null){
            $projets->where(function($query) use ($employeur){
                $query->where('projets.employeur_id',$employeur)->orWhere('demandes.employeur_id',$employeur);
            });
        }

        if($personne != 'ALL' && $personne != null){
            $projets->join('demande_users','demandes.id','=','demande_users.demande_id')
                ->select(['projets.*', 'employeurs.nom','demandes.projet_id','demandes.id as projet_demande_id',
                          'demande_users.user_id as demande_user_id'])
                ->where('demande_users.user_id',$personne);
        }

        if($statut_du_dossier != 'ALL' && $statut_du_dossier != null){
            if($personne == null || $personne == 'ALL'){
                $projets->leftJoin('demande_users','demandes.id','=','demande_users.demande_id');
            }
            $projets->select(['projets.*', 'employeurs.nom','demandes.projet_id',
                              'demandes.id as projet_demande_id','demande_users.user_id as demande_user_id',
                              'demandes.statut as demandes_statut']);
            if(in_array($statut_du_dossier,['IMMIGRATION','RECRUTEMENT'])){
                $demandeStatuArray = [];
                $demandeStatuArray['IMMIGRATION'] = demandeStatuts();
                $demandeStatuArray['RECRUTEMENT'] = demandeStatuts(null,STATUTS_DEMANDE_REC);
                $projets->whereIn('demandes.statut',array_keys($demandeStatuArray[$statut_du_dossier]));
                $projets->groupBy('projets.id');
            }else{
                $projets->where('demandes.statut',$statut_du_dossier);
                $projets->groupBy('projets.id');
            }
        }


        if($isHourlyChecked != false && $isHourlyChecked != 'false'){
            $projets->where('demandes.facturation_horaire','on');
        }



        if(\Auth::user() && \Auth::user()->role_lvl == 3) {
            $user_employee_id = \Auth::user()->employeur_id;

            $projets = $projets->where('projets.employeur_id', '=', $user_employee_id);

            $project_demande = Projet::select('id')->where('employeur_id', '<>', $user_employee_id)
            ->whereHas('demandes', function($q) use ($user_employee_id) {
                $q->where('projets.employeur_id', '=', \Auth::user()->employeur_id);
            });


            $db_pd = DB::table('projets')
                     ->select(['projets.*', 'employeurs.nom'])
                     ->join('employeurs', 'employeurs.id', '=', 'projets.employeur_id')
                     ->whereIn('projets.id', $project_demande);

            if($db_pd->first() != null){
                $projets = $projets->unionAll($db_pd)->get();
            }
        }
        if($isCompletedChecked == false || $isCompletedChecked == 'false'){

            $projectCloned = clone $projets;
            $projectIdsToRemove = [];
            $projectCloned->get()->groupBy('id')->map(function($item) use(&$projectIdsToRemove){
                if($item->count() == $item->where('completed',1)->count()){
                    $projectIdsToRemove[] = $item->first()->id;
                }
            });
            $projets = $projets->get()->whereNotIn('id',$projectIdsToRemove)->unique('id');
        }else{
            $projets = $projets->get()->unique('id');
        }

//        $projets->distinct('projets.id');


        return Datatables::of($projets)
                        ->addColumn('statut', function($m){
                            return __($m->statut);
                        })
                        ->editColumn('numero', function($m){
                            $class = "link";
                            if(Str::contains($m->statut, 'imm_')) $class = "danger";
                            if(Str::contains($m->statut, 'rec_')) $class = "secondary";
                            if(Str::contains($m->statut, 'acc_')) $class = "success";

                            return '<a href="'.action('ProjetController@edit', $m->id).'" class="btn btn-sm btn-'. $class .'"><strong>'.$m->numero.'</strong></a>';
                        })
                        ->editColumn('updated_at', function($m){
                            $date = \Carbon\Carbon::parse($m->updated_at);
                            return $date->diffForHumans() .'<br><small>'.$m->updated_at.'</small>';
                        })
                        ->addColumn('action', function($m){
                            $delete = '<button class="btn btn-sm btn-danger delete_projet" data-projetid="'.$m->id.'" data-num="'.$m->numero.'"><i class="fas fa-trash"></i></button>';
                            return '<a href="'.action('ProjetController@edit', $m->id).'" class="btn btn-sm btn-primary mr-1"><i class="fas fa-user-edit"></i></a>' . $delete;
                        })
                        ->addColumn('facturation_horaire', function($m){
                            $m = Projet::find($m->id);
                            $nb_demande = $m->demandes()->where('facturation_horaire', '=', 'on')->count();
                            if(!$nb_demande) return 'NA';
                            return  '<i class="fas fa-stopwatch text-muted opacity-50" style="font-size: 16px;"></i> X '.$nb_demande;
                        })
                        ->addColumn('employeur_name', function($m) {
                            return $m->nom;
                        })
                        ->addColumn('responsable', function($m) {
                            $m = Projet::find($m->id);
                            if(!is_null($m->responsable)) return $m->responsable->fullname;
                            return 'NA';
                        })
                        ->addColumn('statut_candidat', function($m){
                            return 0;
                            // return count($m->candidats) .' / '. $m->nb_candidats;
                        })
                        ->addColumn('childrow_html', function($m) use ($statut_du_dossier,$isCompletedChecked, $isHourlyChecked){
                            $m = Projet::find($m->id);
                            return $m->childRowHtml($statut_du_dossier, $isCompletedChecked, $isHourlyChecked);
                        })
                        ->make(true);
    }


    public function getRegroupements(){
        return Datatables::of(Regroupement::query())
                        ->editColumn('updated_at', function(Regroupement $r){
                            return $r->updated_at->diffForHumans() .'<br><small>'.$r->updated_at.'</small>';
                        })
                        ->addColumn('action', function(Regroupement $r){
                            return '<a href="'.action('RegroupementController@edit', $r->id).'" class="btn btn-sm btn-primary"><i class="fas fa-user-edit"></i></a>';
                        })
                        ->make(true);
    }

    public function getEmplois(){
        return Datatables::of(Emploi::query())
                        ->editColumn('updated_at', function(Emploi $r){
                            if(is_null($r->updated_at)) return '---';
                            return $r->updated_at->diffForHumans() .'<br><small>'.$r->updated_at.'</small>';
                        })
                        ->addColumn('action', function(Emploi $r){
                            return '<a href="'.action('EmploiController@edit', $r->id).'" class="btn btn-sm btn-primary"><i class="fas fa-user-edit"></i></a>';
                        })
                        ->make(true);
    }

    public function getPays(){
        return Datatables::of(Pays::query())
                        ->editColumn('updated_at', function(Pays $r){
                            if(is_null($r->updated_at)) return '---';
                            return $r->updated_at->diffForHumans() .'<br><small>'.$r->updated_at.'</small>';
                        })
                        ->addColumn('action', function(Pays $r){
                            return '<a href="'.action('PaysController@edit', $r->id).'" class="btn btn-sm btn-primary"><i class="fas fa-user-edit"></i></a>';
                        })
                        ->make(true);
    }


    public function getUsers(){
        return Datatables::of(User::where('role_lvl', '>', 3))
                        ->editColumn('updated_at', function(User $u){
                            return $u->updated_at->diffForHumans() .'<br><small>'.$u->updated_at.'</small>';
                        })
                        ->addColumn('action', function(User $u){
                            return '<a href="'.action('UserController@edit', $u->id).'" class="btn btn-sm btn-primary"><i class="fas fa-user-edit"></i></a>';
                        })
                        ->make(true);
    }


    public function getEmployeurs(){
        return Datatables::of(Employeur::with('regroupement')->with('pays'))
                        ->editColumn('statut', function(Employeur $c){
                            return '<h6>'.$c->statutIconHTML() . '</h6>';
                        })
                        ->editColumn('nom', function(Employeur $c){
                            return '<a href="'.action('EmployeurController@edit', $c->id).'"><h5>'.$c->nom . '</h5></a>';
                        })
                        ->editColumn('contact_nom', function(Employeur $c){
                            $titre = '';
                            if(!empty($c->contact_titre)) $titre = $c->contact_titre.'<br>';

                            return '<strong>'.$c->contact_prenom .' '. $c->contact_nom .'</strong><br><small>'.$titre.'<a href="mailto:'.$c->contact_email.'">'.$c->contact_email.'</a><br><a href="tel:'.$c->contact_phone.'">'.$c->contact_phone.'</a></small>';
                        })
                        ->addColumn('regroupement', function (Employeur $c) {
                            if(!is_null($c->regroupement)) return $c->regroupement->title;
                            return ' -- ';
                        })
                        ->addColumn('pays', function (Employeur $c) {
                            if(!is_null($c->pays)) return $c->pays->title;
                            return ' -- ';
                        })
                        ->editColumn('updated_at', function(Employeur $c){
                            return $c->updated_at->diffForHumans() .'<br><small>'.$c->updated_at.'</small>';
                        })
                        ->addColumn('action', function(Employeur $c){
                            $delete = '<button class="btn btn-sm btn-danger delete_employeur" data-employeurid="'.$c->id.'" data-nom="'.$c->nom.'"><i class="fas fa-trash"></i></button>';
                            if($c->projets()->count()) $delete = '';
                            return '<a href="'.action('EmployeurController@edit', $c->id).'" class="btn btn-sm btn-primary mr-2"><i class="fas fa-user-edit"></i></a> '.$delete;
                        })
                        ->make(true);
    }
}
