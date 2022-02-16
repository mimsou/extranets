<?php

namespace App\Http\Controllers;


use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function ajoutAuCandidat(Request $request){
        $candidat = Candidat::find($request->candidat_id);
        if($request->has('body') && $request->body !== null && $request->body !== '') {
            $candidat->comment(['body' => $request->body], Auth::user());
        }
        $comments = $candidat->comments()->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => true,
            'message' => 'Add new comments!',
            'view' => view('admin.candidats.partials._observation_comments',compact('comments'))->render()
        ]);
    }

    public function getAuCandidat(Request $request){
        $candidat = Candidat::find($request->candidat_id);
        $comments = $candidat->comments()->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => true,
            'message' => 'get comments!',
            'view' => view('admin.candidats.partials._observation_comments',compact('comments'))->render()
        ]);
    }
}