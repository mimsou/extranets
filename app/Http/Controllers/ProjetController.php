<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Demande;
use App\Models\Employeur;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Models\DemandeUser;
use Auth;
use DB;
class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(is_associate_user()){
//            return redirect()->back();
//        }
        $demandeAdminUsers = DemandeUser::with(['user'])->get()->unique('user_id')
            ->pluck('user.firstname','user_id')->prepend('TOUS','');
        return view('admin.projets.index',['personne'=>array_filter($demandeAdminUsers->toArray())]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(is_associate_user()){
            return redirect()->back();
        }
        return view('admin.projets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(is_associate_user()){
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'numero' => 'required',
            'date_creation' => 'required',
        ]);


        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $projet = Projet::create($request->all());

        flash( "Le projet a été créé avec succès")->success();

        return Redirect::action('ProjetController@edit', $projet->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(is_associate_user()){
            if(!it_has_project($id)){
                return redirect()->back();
            }
        }
        if(Auth::user()->role_lvl == 3 && !in_array($id, Auth::user()->employerProjects()->get()->pluck('id')->toArray())) { // user with employer role
            return abort('403');
        }
        $projet = Projet::find($id);

        return view('admin.projets.edit', compact('projet','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'numero' => 'required',
            'date_creation' => 'required',
        ]);


        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $projet = Projet::find($id);
        $projet->update($request->all());

        flash( "Le projet a été mis à jour avec succès")->success();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function addDemande(Request $request, $id){
        $projet = Projet::find($id);

        // Création de la demande
        $projet->demandes()->create($request->all());

        flash( "La demande a été ajouté au projet avec succès")->success();


        return Redirect::back();
    }


    public function demandeDetails(Request $request, $id){
        $demande = Demande::find($request->demande_id);
        $projet = Projet::find($demande->projet_id);



        if($demande->type == 'immigration') $form = '_demandeForm';;
        if($demande->type == 'recrutement') $form = '_demandeRecForm';

        return view('admin.projets.modals._editDemandeForm', compact('demande', 'projet', 'form'));
    }


    public function editDemande(Request $request, $id, $demandeid){
        $demande = Demande::find($demandeid);
        // Création de la demande
        $demande->update($request->all());

        flash( "La demande a été mise à jour avec succès")->success();

        return Redirect::back();
    }


    public function removeDemande($id, $demande_id){
        $demande_id = base64_decode($demande_id);
        $demande = Demande::find($demande_id);

        $demande->delete();

        flash( "La demande a été supprimé avec succès")->success();

        return Redirect::back();
    }



    public function getEmployeurContact(Request $request, $id){
        return Employeur::find($request->employeur_id);
    }



    public function addCandidat(Request $request, $id){
        $demande = Demande::find($request->demande_id);

        $candidats = $demande->candidats()->select('id')->get();

        $final_candidats = [];
        foreach($candidats as $c){
            $final_candidats[$c->id] = ['statut'=> (is_null($c->pivot->statut))?'approved':$c->pivot->statut ];
        }

        if(!empty($request->user_id)){
            $final_candidats[$request->user_id] = ['statut'=>'approved'];

            // dd($final_candidats);
            $demande->candidats()->sync($final_candidats);

            flash( "Le candidat a été ajouté à la demande avec succès")->success();
        }

        // On met à jour le nombre de candidats dans la DB
        $demande->nb_candidat_recrute = $demande->candidats->count();
        $demande->save();

        return Redirect::back();
    }


    public function updateCandidat(Request $request, $id, $candidat_id, $statut){
        $demande = Demande::find($id);
        $candidats = $demande->candidats()->select('id')->get();

        $candidat_id = base64_decode($candidat_id);

        $final_candidats = [];
        foreach($candidats as $c){
            if($candidat_id != $c->id) $final_candidats[$c->id] = ['statut'=> (is_null($c->pivot->statut))?'approved':$c->pivot->statut ];
        }

        $final_candidats[$candidat_id] = ['statut'=> $statut];

        $demande->candidats()->sync($final_candidats);

        // On met à jour le nombre de candidats dans la DB
        $demande->nb_candidat_recrute = $demande->candidats->count();
        $demande->save();

        flash( "Le candidat a été retiré au projet avec succès")->success();

        return Redirect::back();
    }


    public function removeCandidat(Request $request, $id, $candidat_id){
        $demande = Demande::find($id);
        $candidats = $demande->candidats()->select('id')->get();

        $candidat_id = base64_decode($candidat_id);

        $final_candidats = [];
        foreach($candidats as $c){
            if($candidat_id != $c->id) $final_candidats[$c->id] = ['statut'=> (is_null($c->pivot->statut))?'approved':$c->pivot->statut ];
        }

        $demande->candidats()->sync($final_candidats);

        // On met à jour le nombre de candidats dans la DB
        $demande->nb_candidat_recrute = $demande->candidats->count();
        $demande->save();

        flash( "Le candidat a été retiré au projet avec succès")->success();

        return Redirect::back();
    }


    public function remove(Request $request){
        $projet = Projet::find($request->projet_id);

        foreach($projet->demandes as $key => $d) {
            $d->candidats()->sync([]);
        }
        $projet->delete();
        flash( "Le projet a été supprimé avec succès")->success();
        return Redirect::to($request->redirect_to);
    }

}
