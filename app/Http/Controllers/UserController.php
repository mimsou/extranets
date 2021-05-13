<?php

namespace App\Http\Controllers;

use App\Mail\DemandeComment;
use App\Models\Demande;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use Redirect;
use Validator;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
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
        if (Auth::user()->role_lvl < 10) abort(404);
        $user = new User;
        return view('admin.users.create', compact('user'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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

        if (!empty($request->new_password)) {
            $new_user['password'] = Hash::make($request->new_password);
        }

        $user = User::create($new_user);

        flash()->success("L'utilisateur à bien été créé");

        if ($request->has('employeur_id')) return redirect()->action('EmployeurController@userManagement', ['id' => $request->employeur_id]);

        return Redirect::action('UserController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (Auth::user()->role_lvl < 10 && Auth::user()->id != $user->id) return abort(404);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
        if (!empty($request->new_password)) {
            $req_user['password'] = Hash::make($request->new_password);
        } else {
            $req_user['password'] = $user->password;
        }

        $user->update($req_user);

        flash()->success("L'utilisateur à bien été mis à jour");

        if ($request->has('employeur_id')) return redirect()->action('EmployeurController@userManagement', ['id' => $request->employeur_id]);

        return Redirect::action('UserController@edit', $user->id);
    }


    /**
     * Save Comment and send email to assigned admin if Model is Demande
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function saveComment(Request $request)
    {
        $class = $request->model_type;
        $model = $class::where('id', '=', $request->model_id)->first();
        if (class_basename($class) == 'Demande') {
            $users = $model->assignedUsers()->get();
            foreach ($users as $k => $user) {
                if (sendEmailEnv($user->email)) {
                    Mail::to($user->email)->queue(new DemandeComment($user, Auth::user()->full_name, $request->message, $model->projet));
                }
            }
        }
        if (!is_null($model)) {
            $n = $model->noteThat($request->message, $request->category);
            return view('admin.partials._message', compact('n'));
        } else {
            return 'model does not exist';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get Comments
     *
     * @param Request $request
     * @return string
     */
    public function getComments(Request $request)
    {
        if ($request->has('limit') && $request->limit != null) {
            $comments = Demande::find($request->demande_id)->getNotes()->sortByDesc('id')->take(2)->reverse();
        } else {
            $comments = Demande::find($request->demande_id)->getNotes();
        }
        $html = '';
        foreach ($comments as $key => $comment) {
            $html .= view('admin.partials._message', ['n' => $comment])->render();
        }
        return ['count' => $comments->count(), 'html' => $html];
    }
}