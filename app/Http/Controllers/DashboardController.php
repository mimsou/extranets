<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Demande;
use App\Models\Projet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request){
        if(Auth::user() && Auth::user()->role_lvl == 3) { //user is employer
            $employeur = \App\Models\Employeur::find(Auth::user()->employeur_id);
            return view('admin.employeurs.edit', compact('employeur'));
        }
        $counts = $this->dashboardRecords($request);
        return view('dashboard',compact('counts'));
    }

    public function dashboardRecords(Request $request){
        if($request->has('start_date') && $request->has('end_date')){
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        }else{
            $dateSevendDaysBefore = Carbon::now()->subDays(7);
            $dateSevendDaysBefore = $dateSevendDaysBefore->format('Y-m-d');
            $startDate = $dateSevendDaysBefore;
            $endDate = Carbon::now()->format('Y-m-d');
        }

        //Emit
        $demandesModel = Demande::whereBetween('eimt_date_envoi',[$startDate,$endDate])->get();
        $emitCount = $demandesModel->count();
        $demandesModel = Demande::whereBetween('eimt_date_reception',[$startDate,$endDate])->get();
        $emitApprovedCount = $demandesModel->count();

        //DST Count
        $demandeModel = Demande::whereBetween('dst_date_envoi',[$startDate,$endDate])->get();
        $dstCount = $demandeModel->count();
        $demandesModel = Demande::whereBetween('dst_date_reception',[$startDate,$endDate])->get();
        $dstApprovedCunt = $demandesModel->count();


        //project completed
        $projetModel = Projet::whereBetween('date_selection',[$startDate,$endDate])->get();
        $completedCount = $projetModel->count();

        //PT sent
        $candidateModel = Candidat::whereBetween('permis_date_envoi',[$startDate,$endDate])->get();
        $permisDateEnvoiCount = $candidateModel->count();

        //PT received
        $candidateModel = Candidat::whereBetween('permis_date_reception',[$startDate,$endDate])->get();
        $permisDateApprovedCount = $candidateModel->count();

        return ['emit'=>$emitCount,'emit_approved'=>$emitApprovedCount,'dst_count'=>$dstCount,
                'dst_approved_cont'=>$dstApprovedCunt,
                'project_complete'=>$completedCount,'pt_sent'=>$permisDateEnvoiCount,
                'pt_received'=>$permisDateApprovedCount];
    }

    public function getCountsByFilter(Request $request){
        $counts = $this->dashboardRecords($request);
        return view('admin.dashboard.widgets',compact('counts'))->render();
    }
}
