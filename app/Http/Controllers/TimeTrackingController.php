<?php

namespace App\Http\Controllers;

use Str;
use App\Classes\Utils\Tools\DateTools;
use App\Classes\Utils\Tools\TimeTools;
use App\Models\Employeur;
use App\Models\Projet;
use App\Models\TimeRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TimeTrackingController extends Controller
{
    /**
     * Display a flash!
     *
     * @return \Illuminate\Http\Response
     */
    public function flash()
    {
        //https://github.com/laracasts/flash/issues/111
        return view('admin.time-trackings.partials.message');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(is_super_admin_user() === false){
            abort(404);
        }

        $users = User::all()
            ->pluck('fullname', 'id')
            ->prepend('Tous',0)
            ->toArray();

        $projects = Projet::all()
            ->pluck('titre', 'id')
            ->prepend('Tous',0)
            ->toArray();

        $statuts = collect(Projet::getProjetDeType())
            ->prepend('Tous','all');

        $employeurs = Employeur::orderBy('nom', 'ASC')
            ->pluck('nom', 'id')
            ->prepend('Tous',0);

        return view('admin.time-trackings.index',
                    compact('users', 'projects', 'statuts', 'employeurs'));
    }

    public function getDatatableContent(Request $request)
    {
        // Date from to handling
        if($request->has('date_from') && $request->has('date_to')){
            if(DateTools::checkDateBeforeAfter($request->date_from, $request->date_to)){
                $date_from = Carbon::parse($request->date_from);
                $date_to = Carbon::parse($request->date_to);
            }else{
                $date_from = now()->startOfMonth();
                $date_to = now()->endOfMonth();
            }
        }else{
            $date_from = now()->startOfMonth();
            $date_to = now()->endOfMonth();
        }

        //Building the dynamic Query from the data received
        $query = TimeRecord::whereBetween('date_from',[$date_from,$date_to])
            ->with('projet', 'projet.employeur')
            ->selectRaw("*, SUM(duration) as total_hours")
            ->groupBy('projet_id');

        if($request->has('user') && $request->user !== "0"){
            $query = $query->where('user_id','=',$request->user);
        }

        $has_task_type = false;
        $task_type = null;
        if($request->has('task_type') && $request->task_type !== "all"){
            $has_task_type = true;
            $task_type = $request->task_type;
            $query = $query->where('task_type','=',$request->task_type);
        }

        if($request->has('projet') && $request->projet !== "0"){
            $query = $query->where('projet_id','=',$request->projet);
        }

        if($request->has('projet_type') && $request->projet_type !== "all"){
            $query = $query->whereHas('projet', function ($q) use ($request){
                $q->where('statut','=',$request->projet_type);
            });
        }

        if($request->has('employeur') && $request->employeur !== "0"){
            $query = $query->whereHas('projet.employeur', function ($q) use ($request){
                $q->where('id','=',$request->employeur);
            });
        }

        return Datatables::of($query->get())
            ->editColumn(
                'total_hours', function($m) {
                return TimeTools::floatToHours($m->total_hours);
            })
            ->editColumn(
                'projet.titre', function($m) {
                return '<a href="' . action('ProjetController@edit', $m->projet->id) . '" class="btn btn-sm btn-link"><strong>' . $m->projet->titre . '</strong></a>';
            })
            ->editColumn(
                'projet.numero', function($m) {
                $class = "link";
                $p = $m->projet;
                if(Str::contains($p->statut, 'imm_')) $class = "danger";
                if(Str::contains($p->statut, 'rec_')) $class = "secondary";
                if(Str::contains($p->statut, 'acc_')) $class = "success";

                return '<a href="' . action('ProjetController@edit', $m->projet->id) . '" class="btn btn-sm btn-'.$class.'"><strong>' . $m->projet->numero . '</strong></a>';
            })
            ->editColumn(
                'projet.statut', function($m) {
                return __($m->projet->statut);
            })
            ->addColumn(
                'childrow_html', function($m)  use ($has_task_type, $task_type){
                    $projet = Projet::where('id', '=', $m->projet_id)
                                ->with('time_records',function($q){
                                    $q->selectRaw("*,SUM(duration) as total_hours")
                                        ->with('user')
                                        ->groupBy('user_id');
                                })
                                ->first();
                    if($has_task_type === true) {
                        foreach ($projet->time_records as $tr) {
                            $trWithTaskTypeTotal = TimeRecord::where('user_id', '=', $tr->user->id)
                                ->where('task_type', '=', $task_type)
                                ->selectRaw("SUM(duration) as total_for_task_type_selected")
                                ->first();
                            //Inject optional data if a taskType is selected
                            $tr->total_for_task_type_selected = $trWithTaskTypeTotal->total_for_task_type_selected;
                            $tr->task_type_selected = $task_type;
                        }
                    }
                return view('admin.time-trackings.partials.datatable_row_child',
                            compact('projet', 'has_task_type', 'task_type'));
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request):JsonResponse
    {
        try {
            $duration = TimeTools::hoursToFloat($request->tt_duration);
        }catch (\Exception $e){
            abort(500);
        }

        $tr = new TimeRecord();
        $tr->user_id = $request->tt_user_id;
        $tr->by_user_id = Auth::user()->id;
        $tr->projet_id = $request->tt_projet_id;
        $tr->task_type = $request->tt_task_type;
        $tr->description = $request->tt_description??'';
        $tr->duration = $duration;
        $tr->date_from = $request->tt_date_from??now();
        $tr->save();

        return response()->json([
            'success' => true,
            'action' => 'TimeTrackingController@store'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(is_super_admin_user()){
            $time_records = TimeRecord::where('projet_id', '=', $id)
                ->orderBy('date_from', 'DESC')
                ->get();
        }else{
            $time_records = TimeRecord::where('projet_id', '=', $id)
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy('date_from', 'DESC')
                ->get();
        }
        $time_record_datas = [];
        $total_duration = 0;
        foreach ($time_records as $time_record){
            $time_record_datas[] = [
                'name' => $time_record->user->fullname,
                'date' => $time_record->date_from,
                'duration' => TimeTools::floatToHours($time_record->duration),
                'type' => $time_record->task_type,
                'description' => $time_record->description
            ];
            $total_duration += $time_record->duration;
        }
        $total = TimeTools::floatToHours($total_duration);

        return view('admin.time-trackings.partials.record_per_project',
                    compact('time_record_datas', 'total'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $projet_id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function showDetails($projet_id, $user_id)
    {
        //
        //---o Time records list by projet & user
        //
        $time_records = TimeRecord::where('projet_id', '=', $projet_id)
            ->where('user_id', '=', $user_id)
            ->orderBy('date_from', 'DESC')
            ->get();
        $time_record_datas = [];
        $total_duration = 0;
        foreach ($time_records as $time_record){
            $time_record_datas[] = [
                'name' => $time_record->user->fullname,
                'date' => $time_record->date_from,
                'duration' => TimeTools::floatToHours($time_record->duration),
                'type' => $time_record->task_type,
                'description' => $time_record->description
            ];
            $total_duration += $time_record->duration;
        }
        //
        //---o Time records breakdown by Task Type
        //
        $time_record_by_task_type = collect([]);
        foreach ($time_records as $time_record){
            $data = [
                'name' => $time_record->user->fullname,
                'date' => $time_record->date_from,
                'duration' => TimeTools::floatToHours($time_record->duration),
                'type' => $time_record->task_type,
                'description' => $time_record->description
            ];
            //Lazy creating
            if($time_record_by_task_type->has($time_record->task_type) === false){
                $time_record_by_task_type->put($time_record->task_type,collect([]));
            }
            $time_record_by_task_type->get($time_record->task_type)->push($time_record->duration);
        }
        //
        //---o Extra details
        //
        $total = TimeTools::floatToHours($total_duration);
        $user = User::find($user_id);
        $projet = Projet::find($projet_id);

        $view = view('admin.time-trackings.partials.record_per_user',
                    compact('time_record_datas', 'total', 'user', 'projet', 'time_record_by_task_type'))->render();

        return response()->json([
                'success' => true,
                'view' => $view
            ]);
    }
}
