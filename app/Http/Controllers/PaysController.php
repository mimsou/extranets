<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pays.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pays.create');
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
            'title' => 'required',
            'abrev' => 'required',
        ]);


        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $r = Pays::create($request->all());

        flash( "Le poste a été créé avec succès")->success();

        return Redirect::action('PaysController@edit', $r->id);
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
        $pays = Pays::find($id);
        return view('admin.pays.edit', compact('pays'));
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
            'title' => 'required',
            'abrev' => 'required',
        ]);


        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $r = Pays::find($id);
        $r->update($request->all());

        flash( "Le poste a été mis à jour avec succès")->success();

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
}
