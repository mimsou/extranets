<?php

namespace App\Http\Controllers;

use App\Classes\Utils\Tools\DateTools;
use App\Classes\Utils\Tools\TimeTools;
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

        $users = User::all()->pluck('fullname', 'id')->toArray();
        $projects = Projet::all()->pluck('titre', 'id')->toArray();

        return view('admin.time-trackings.index', compact('users', 'projects'));
    }

    public function getDatatableContent(Request $request)
    {
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

        $query = TimeRecord::whereBetween('date_from',[$date_from,$date_to])
            ->with('projet', 'projet.employeur')
            ->selectRaw("*, SUM(duration) as total_hours")
            ->groupBy('projet_id');

        if($request->has('user') && $request->user !== "0"){
            $query = $query->where('user_id','=',$request->user);
        }

        if($request->has('projet') && $request->projet !== "0"){
            $query = $query->where('projet_id','=',$request->projet);
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
                return '<a href="' . action('ProjetController@edit', $m->projet->id) . '" class="btn btn-sm btn-link"><strong>' . $m->projet->numero . '</strong></a>';
            })
            ->addColumn(
                'childrow_html', function($m)  {
                    $projet = Projet::where('id', '=', $m->projet_id)
                            ->with('time_records',function($q){
                                $q->selectRaw("*,SUM(duration) as total_hours")->with('user')->groupBy('user_id');
                            })
                    ->first();
//                    dump($projet);
                return view('admin.time-trackings.partials.datatable_row_child', compact('projet'));
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
            $time_records = TimeRecord::where('projet_id', '=', $id)->get();
        }else{
            $time_records = TimeRecord::where('projet_id', '=', $id)
                ->where('user_id', '=', Auth::user()->id)
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
}
