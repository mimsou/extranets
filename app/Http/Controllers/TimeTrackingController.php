<?php

namespace App\Http\Controllers;

use App\Classes\Utils\Tools\TimeTools;
use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.time-trackings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tr = new TimeRecord();
        $tr->user_id = $request->tt_user_id;
        $tr->by_user_id = Auth::user()->id;
        $tr->projet_id = $request->tt_projet_id;
        $tr->task_type = $request->tt_task_type;
        $tr->description = $request->tt_description??'';
        $tr->duration = TimeTools::hoursToFloat($request->tt_duration);
        $tr->date_from = now();
        $tr->save();

        return [
            'success' => true,
            'action' => 'TimeTrackingController@store',
            'time' => TimeTools::floatToHours($tr->duration)
        ];
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
