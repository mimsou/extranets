<?php

namespace App\Classes\Utils\Notify;

use App\Models\DemandeUser;
use App\Mail\DemandeUpdate;
use Mail;
use Auth;

trait Notify{

    protected static function boot(){
        parent::boot();

        static::updating(function($model){
            $demandeUsers = DemandeUser::with(['user'])->where(['demande_id'=>$model->id])->get();
            Mail::to($demandeUsers->pluck('user.email'))->queue(new DemandeUpdate($demandeUsers, Auth::user()->full_name,$model->getDirty(),$model));
        });
    }
}
