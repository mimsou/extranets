<?php

namespace App\Http\Controllers;

use App\Models\Employeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

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
}
