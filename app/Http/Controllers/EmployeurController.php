<?php

namespace App\Http\Controllers;

use App\Models\Employeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Auth;

class EmployeurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employeurs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeur = new Employeur;
        return view('admin.employeurs.create', compact('employeur'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
        ]);


        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $employeur = Employeur::create($request->all());

        flash( "L'employeur a été créé avec succès")->success();

        return Redirect::action('EmployeurController@edit', $employeur->id);
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
        if(Auth::user()->role_lvl == 3 && Auth::user()->employeur_id != $id) { // user with employer role
            return abort('403');
        }
        $employeur = Employeur::find($id);
        return view('admin.employeurs.edit', compact('employeur'));
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
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
        ]);


        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $employeur = Employeur::find($id);
        $employeur->update($request->all());

        if(!$request->has('has_secondary_contact')){
            $employeur->has_secondary_contact = null;
            $employeur->save();
        }

        flash( "L'employeur a été mis à jour avec succès")->success();

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

    }

    public function remove(Request $request){
        Employeur::find($request->employeur_id)->delete();
        flash( "L'employeur a été supprimé avec succès")->success();
        return Redirect::to($request->redirect_to);
    }

    public function userManagement($id)
    {
        if(Auth::user()->role_lvl <=3 ) return abort('403');
        $employeur =  Employeur::find($id);
        return view('admin.employeurs.user-management.index', compact('employeur'));
    }

    public function createUser($id)
    {
        if(Auth::user()->role_lvl <=3 ) return abort('403');
        $employeur =  Employeur::find($id);
        return view('admin.employeurs.user-management.create', compact('employeur'));
    }

    public function editUser($id, $user_id) {
        if(Auth::user()->role_lvl <=3 ) return abort('403');
        $employeur =  Employeur::find($id);
        $user = User::find($user_id);
        return view('admin.employeurs.user-management.edit', compact('employeur', 'user'));
    }

    public function deleteUser($id, Request $request)
    {
        if(Auth::user()->role_lvl <=3 ) return abort('403');
        $user = User::find($request->user_id)->delete();
        flash( "User a été supprimé avec succès")->success();
        return Redirect::to($request->redirect_to);
    }
}
