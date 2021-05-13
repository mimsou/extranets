<?php

namespace App\Http\Controllers;

use App\Mail\DemandeAssigned;
use App\Models\Demande;
use App\Models\DemandeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class DemandeController
 * @package App\Http\Controllers
 */
class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Demande $demande
     * @return \Illuminate\Http\Response
     */
    public function show(Demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Demande $demande
     * @return \Illuminate\Http\Response
     */
    public function edit(Demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Demande $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Demande $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        //
    }

    /**
     * Add assignee to Demande
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assingUser(Request $request)
    {
        $demande = Demande::find($request->demande_id);
        $user = User::find($request->user_id);
        if (is_null($demande->assignedUsers->find($request->user_id))) {
            $demande->assignedUsers()->syncWithoutDetaching($request->user_id);
            if (sendEmailEnv($user->email)) {
                Mail::to($user->email)->queue(new DemandeAssigned($user, Auth::user()->full_name, $demande->projet, $demande));
            }
            return response()->json(['initials' => $user->initials(), 'status' => true]);
        } else {
            return response()->json(['status' => false, 'message' => 'Déjà assigné à la demande!']);
        }
    }

    /**
     * Remove assignee from demande
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAssignee(Request $request)
    {
        $demandeModel = DemandeUser::where(['demande_id' => $request->demand_id, 'user_id' => $request->assignee_id])->delete();
        return response()->json(['status' => true, 'demande deleted successfully!']);
    }
}
