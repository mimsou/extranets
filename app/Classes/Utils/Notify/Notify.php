<?php

namespace App\Classes\Utils\Notify;

use App\Mail\DemandeUpdate;
use App\Models\DemandeUser;
use Auth;
use Mail;

/**
 * Notify all assignees of Demande after any update in demande
 * Trait Notify
 * @package App\Classes\Utils\Notify
 */
trait Notify
{

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $demandeUsers = DemandeUser::with(['user'])
                ->where(['demande_id' => $model->id])
                ->get();
            if($demandeUsers->pluck('user.email')->count() > 0) {
                Mail::to($demandeUsers->pluck('user.email'))
                    ->queue(new DemandeUpdate($demandeUsers, Auth::user()->full_name, $model->getDirty(), $model));
            }
        });
    }
}