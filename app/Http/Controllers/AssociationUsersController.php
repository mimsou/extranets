<?php

namespace App\Http\Controllers;

use App\DataTables\AssociationUsersDataTable;
use App\Models\AssocUserMap;
use App\Models\Regroupement;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AssociationUsersController extends Controller
{
    public function index(AssociationUsersDataTable $dataTable)
    {
        if(auth()->user()->role_lvl != 10){
            return back();
        }
        $association = Regroupement::find(request()->assoc_group_id);
        return $dataTable->with(['group_assoc_id' => request()->assoc_group_id])
            ->render('admin.association-users.index', ['association' => $association]);
    }

    public function create()
    {
        return view('admin.association-users.create');
    }

    public function store(Request $request, $assocGroupId)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ];
        DB::beginTransaction();
        try {
            $request->validate($rules);
            $userModel = new User;
            $userModel->fill($request->except(['password']));
            $userModel->password = Hash::make($request->password);
            $userModel->role_lvl = 2;
            $userModel->save();

            $groupAssoc = new AssocUserMap;
            $groupAssoc->group_id = $assocGroupId;
            $groupAssoc->user_id = $userModel->id;
            $groupAssoc->save();
            DB::commit();
            flash("Association user created successfully!")->success();
            return redirect()->route('association.users', $assocGroupId);
        } catch(\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function edit($assoc_group_id, $user_id)
    {
        $user = User::find($user_id);
        return view('admin.association-users.edit', ['group_id' => $assoc_group_id, 'user' => $user]);
    }

    public function update($assoc_group_id, $user_id, Request $request)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users,email,' . $user_id,
            'password' => 'confirmed'
        ];

        $userModel = User::find($user_id);
        $userModel->fill($request->except(['password']));
        if($request->has('password') && $request->password != '') {
            $userModel->password = Hash::make($request->password);
        }
        $userModel->save();
        flash("Association user updated successfully!")->success();
        return redirect()->route('association.users', $assoc_group_id);
    }

    public function remove(Request $request)
    {
        AssocUserMap::where(['group_id' => $request->group_id, 'user_id' => $request->user_id])->delete();
        User::find($request->user_id)->delete();
        flash("Association user deleted successfully!")->success();
        return redirect()->to($request->redirect_to);
    }
}
