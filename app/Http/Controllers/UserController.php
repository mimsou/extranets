<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use Redirect;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_lvl < 10) abort(404);
        $user = new User;
        return view('admin.users.create', compact('user'));
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
            'email' => ['required', Rule::unique('users')],
            'firstname' => 'required',
            'lastname' => 'required',
            'new_password' => 'required',
            'new_password_confirm' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            flash("Oups, il semble y avoir un problème!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $new_user = $request->all();

        if(!empty($request->new_password)){
            $new_user['password'] = Hash::make($request->new_password);
        }

        $user = User::create($new_user);

        flash()->success("L'utilisateur à bien été créé");

        return Redirect::action('UserController@index');
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
        $user = User::find($id);
        if(Auth::user()->role_lvl < 10 && Auth::user()->id != $user->id) return abort(404);
        return view('admin.users.edit', compact('user'));
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
        $user = User::findorfail($id);

        $validator = Validator::make($request->all(), [
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'firstname' => 'required',
            'lastname' => 'required',
            'new_password_confirm' => 'same:new_password',
        ]);

        if ($validator->fails()) {
            flash("Oups, il semble y avoir un problème!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $req_user = $request->all();

        // On met le mot de passe à jour au besoin
        if(!empty($request->new_password)){
            $req_user['password'] = Hash::make($request->new_password);
        }else{
            $req_user['password'] = $user->password;
        }

        $user->update($req_user);

        flash()->success("L'utilisateur à bien été mis à jour");

        return Redirect::action('UserController@edit', $user->id);
    }


    public function saveComment(Request $request){
        // dd($request->all());

        $class = $request->model_type;
        $model = $class::where('id', '=', $request->model_id)->first();

        if(!is_null($model)){
            $n = $model->noteThat($request->message, $request->category);
            return view('admin.partials._message', compact('n'));
        }else{
            return 'model does not exist';
        }
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
