<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCandidats()
    {
        return Datatables::of(Candidat::query())
                        ->editColumn('statut', function(Candidat $c){
                            return $c->statutIconHTML() . '<small class="pl-2">'.$c->statutReadable().'</small>';
                        })
                        ->addColumn('action', function(Candidat $c){
                            return '<a href="'.action('CandidatController@edit', $c->id).'" class="btn btn-sm btn-primary"><i class="fas fa-user-edit"></i></a>';
                        })
                        ->make(true);
    }
}
