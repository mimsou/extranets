<?php

namespace App\Http\Controllers;

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


    public function getProjets(){
        return Datatables::of(Projet::with('employeur')->select('projets.*', 'employeurs.nom'))
                        ->addColumn('statut', function(Projet $m){
                            return __($m->statut);
                        })
                        ->editColumn('numero', function(Projet $m){
                            $class = "link";
                            if(Str::contains($m->statut, 'imm_')) $class = "danger";
                            if(Str::contains($m->statut, 'rec_')) $class = "secondary";
                            if(Str::contains($m->statut, 'acc_')) $class = "success";

                            return '<a href="'.action('ProjetController@edit', $m->id).'" class="btn btn-sm btn-'. $class .'"><strong>'.$m->numero.'</strong></a>';
                        })
                        ->editColumn('updated_at', function(Projet $m){
                            return $m->updated_at->diffForHumans() .'<br><small>'.$m->updated_at.'</small>';
                        })
                        ->addColumn('action', function(Projet $m){
                            $delete = '<button class="btn btn-sm btn-danger delete_projet" data-projetid="'.$m->id.'" data-num="'.$m->numero.'"><i class="fas fa-trash"></i></button>';
                            return '<a href="'.action('ProjetController@edit', $m->id).'" class="btn btn-sm btn-primary mr-3"><i class="fas fa-user-edit"></i></a> ' . $delete;
                        })
                        ->addColumn('statut_candidat', function(Projet $m){
                            return 0;
                            // return count($m->candidats) .' / '. $m->nb_candidats;
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
        return Datatables::of(User::query())
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
