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
        if(is_associate_user()){
            return redirect()->route('employeurs.index');
        }
        if(Auth::user() && Auth::user()->role_lvl == 3) { //user is employer
            $employeur = \App\Models\Employeur::find(Auth::user()->employeur_id);
            return view('admin.employeurs.edit', compact('employeur'));
        }
        $chartData = $this->getChartData($request);
        $counts = $this->dashboardRecords($request);
        return view('dashboard',compact('counts','chartData'));
    }

    public function nosBonsCoups(){
        return view('dashboard-details');
    }

    public function dashboardRecords(Request $request){
        if($request->has('start_date') && $request->has('end_date')){
            $startDate = Carbon::parse($request->start_date);
            if($request->has('compareCondition') && $request->compareCondition == "true"){
                $startDate = $startDate->subYears(1);
            }
            $endDate = Carbon::parse($request->end_date);
            $dateSevendDaysBefore = $startDate->format('Y-m-d');
            $fourteenDaysBefore = $startDate->subDays($startDate->diffInDays($endDate))->format('Y-m-d');
            $endDate = $request->end_date;
        }else{
            $dateSevendDaysBefore = Carbon::now()->subDays(7);
            $fourteenDaysBefore = Carbon::now()->subDays(14)->format('Y-m-d');
            $dateSevendDaysBefore = $dateSevendDaysBefore->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        }

        //Emit
        $demandesModel = Demande::whereBetween('eimt_date_envoi',[$fourteenDaysBefore,$endDate])->get();
        $demandesCount = $demandesModel->whereBetween('eimt_date_envoi',[$dateSevendDaysBefore,$endDate]);
        $emitCount = $demandesCount->count();
        $avgCount = $demandesModel->whereBetween('eimt_date_envoi',[$fourteenDaysBefore,$dateSevendDaysBefore]);
        $lastWeekCount = $avgCount->count();
        $emitPercentage = $this->getPercentage($lastWeekCount,$emitCount);

        $demandesModel = Demande::whereBetween('eimt_date_reception',[$fourteenDaysBefore,$endDate])->get();
        $emitApprovedCount = $demandesModel->whereBetween('eimt_date_reception',[$dateSevendDaysBefore,$endDate])->count();
        $lastWeekCount = $demandesModel->whereBetween('eimt_date_reception',[$fourteenDaysBefore,$dateSevendDaysBefore])->count();
        $emitApprovePercent = $this->getPercentage($lastWeekCount,$emitApprovedCount);

        //DST Count
        $demandeModel = Demande::whereBetween('dst_date_envoi',[$fourteenDaysBefore,$endDate])->get();
        $dstCount = $demandeModel->whereBetween('dst_date_envoi',[$dateSevendDaysBefore,$endDate])->count();
        $lastWeekCount = $demandeModel->whereBetween('dst_date_envoi',[$fourteenDaysBefore,$dateSevendDaysBefore])->count();
        $dstPercent = $this->getPercentage($lastWeekCount,$dstCount);

        $demandesModel = Demande::whereBetween('dst_date_reception',[$fourteenDaysBefore,$endDate])->get();
        $dstApprovedCunt = $demandesModel->whereBetween('dst_date_reception',[$dateSevendDaysBefore,$endDate])->count();
        $lastWeekCount = $demandesModel->whereBetween('dst_date_reception',[$fourteenDaysBefore,$dateSevendDaysBefore])->count();
        $dstApprovedPercent = $this->getPercentage($lastWeekCount,$dstApprovedCunt);

        //project completed
        $projetModel = Projet::whereBetween('date_selection',[$fourteenDaysBefore,$endDate])->get();
        $completedCount = $projetModel->whereBetween('date_selection',[$dateSevendDaysBefore,$endDate])->count();
        $lastWeekCount = $projetModel->whereBetween('date_selection',[$fourteenDaysBefore,$dateSevendDaysBefore])->count();
        $projetPercent = $this->getPercentage($lastWeekCount,$completedCount);

        //PT sent
        $candidateModel = Candidat::whereBetween('permis_date_envoi',[$fourteenDaysBefore,$endDate])->get();
        $permisDateEnvoiCount = $candidateModel->whereBetween('permis_date_envoi',[$dateSevendDaysBefore,$endDate])->count();
        $lastWeekCount = $candidateModel->whereBetween('permis_date_envoi',[$fourteenDaysBefore,$dateSevendDaysBefore])->count();
        $candidatePercent = $this->getPercentage($lastWeekCount,$permisDateEnvoiCount);

        //PT received
        $candidateModel = Candidat::whereBetween('permis_date_reception',[$fourteenDaysBefore,$endDate])->get();
        $permisDateApprovedCount = $candidateModel->whereBetween('permis_date_reception',[$dateSevendDaysBefore,$endDate])->count();
        $lastWeekCount = $candidateModel->whereBetween('permis_date_reception',[$fourteenDaysBefore,$dateSevendDaysBefore])->count();
        $permisDateApprovedPercent = $this->getPercentage($lastWeekCount,$permisDateApprovedCount);

        return [
                'emit'=>$emitCount,
                'emit_percent' => $emitPercentage,
                'emit_approved'=>$emitApprovedCount,
                'emit_approved_percent'=>$emitApprovePercent,
                'dst_count'=>$dstCount,
                'dst_percent' => $dstPercent,
                'dst_approved_cont'=>$dstApprovedCunt,
                'dst_approved_percent' => $dstApprovedPercent,
                'project_complete'=>$completedCount,
                'project_complete_percent' => $projetPercent,
                'pt_sent'=>$permisDateEnvoiCount,
                'pt_sent_percent' => $candidatePercent,
                'pt_received'=>$permisDateApprovedCount,
                'pt_received_percent'=>$permisDateApprovedPercent
        ];
    }

    public function getChartData(Request $request){
        $lastMonthsDate = Carbon::now()->subMonths(12)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');


        $demandesModel = Demande::whereBetween('eimt_date_envoi',[$lastMonthsDate,$now])->get();
        $demandeEmit = $demandesModel->groupBy(function($item){
            return Carbon::parse($item->eimt_date_envoi)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });


        $demandesModel = Demande::whereBetween('eimt_date_reception',[$lastMonthsDate,$now])->get();
        $demandeEmitApproved = $demandesModel->groupBy(function($item){
            return Carbon::parse($item->eimt_date_reception)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });


        //DST Count
        $demandeModel = Demande::whereBetween('dst_date_envoi',[$lastMonthsDate,$now])->get();
        $demandeDist = $demandeModel->groupBy(function($item){
            return Carbon::parse($item->dst_date_envoi)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });

        //DST Approved
        $demandesModel = Demande::whereBetween('dst_date_reception',[$lastMonthsDate,$now])->get();
        $demandeDistApproved = $demandesModel->groupBy(function($item){
            return Carbon::parse($item->dst_date_reception)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });

        //project completed
        $projetModel = Projet::whereBetween('date_selection',[$lastMonthsDate,$now])->get();
        $projectComplete = $projetModel->groupBy(function($item){
            return Carbon::parse($item->date_selection)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });

        //PT sent
        $candidateModel = Candidat::whereBetween('permis_date_envoi',[$lastMonthsDate,$now])->get();
        $candidatePtSent = $candidateModel->groupBy(function($item){
            return Carbon::parse($item->permis_date_envoi)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });

        //PT received
        $candidateModel = Candidat::whereBetween('permis_date_reception',[$lastMonthsDate,$now])->get();
        $candidatePtRecv = $candidateModel->groupBy(function($item){
            return Carbon::parse($item->permis_date_reception)->format('m');
        })->sortBy(function($value,$key){
            return $key;
        })->mapWithKeys(function($item,$key){
            return [Carbon::createFromFormat('m',$key)->format('M') => $item->count()];
        });

        return [
            'emit' => $demandeEmit->toArray(),
            'emit_approved' => $demandeEmitApproved->toArray(),
            'demande_dist' => $demandeDist->toArray(),
            'dist_approved' => $demandeDistApproved->toArray(),
            'project_complete' => $projectComplete->toArray(),
            'pt_sent' => $candidatePtSent->toArray(),
            'pt_received' => $candidatePtRecv->toArray(),
            'from_date' => $lastMonthsDate,
            'to_date' => $now
        ];
    }



    /**
     * @param $firstCount // last week count
     * @param $secondCount // this week count
     *
     * Formula
     * Current Period Sales - Prior Period Sales
     * ------------------------------------------   = Growth Rate
     *      Prior Period Sales * 100
     *
     * (($secondCount - $firstCount)/$firstCount)*100
     */
    public function getPercentage($firstCount, $secondCount){
        if($firstCount != 0){
            $result = (($secondCount - $firstCount)/$firstCount) * 100;
            if($result > 0){
                return $result;
            }else{
                return $result;
            }
        }elseif($secondCount != 0){
            return 100;
        }else{
            return 0;
        }
    }

    public function getCountsByFilter(Request $request){
        $counts = $this->dashboardRecords($request);
        return view('admin.dashboard.widgets',compact('counts'))->render();
    }
}
