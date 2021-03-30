<?php

namespace App\Http\Controllers;

use Redirect;
use Validator;
use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Auth;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.candidats.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.candidats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            // 'numero' => ['required', Rule::unique('candidats')],
            'statut' => 'required'
        ]);

        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $candidat = Candidat::create($request->all());

        flash('Le candidat a été créé avec succès')->success();

        return Redirect::action('CandidatController@edit', $candidat->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidat = Candidat::find($id);
        if(Auth::user()->role_lvl == 3) {
            $user_demandes = $candidat->demandes()
                                ->where('projet_id', Auth::user()->employerProjects()->get()->pluck('id')->toArray());
            if($user_demandes->get()->count() == 0) return abort('403');
        }
        return view('admin.candidats.edit', compact('candidat'));
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

        $candidat = Candidat::find($id);
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            // 'numero' => ['required', Rule::unique('candidats')->ignore($id)],
            'statut' => 'required'
        ]);

        if ($validator->fails()) {
            flash("Oups, une ou des erreurs se sont produites!")->error();

            return back()->withErrors($validator)->withInput();
        }

        $candidat->update($request->all());

        flash('Le candidat a été mis à jour avec succès')->success();

        return back();
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


    /**
     * Upload additional resources using ajax and Dropzone.js
     *
     * @param [type] $candidat_id
     * @param FileReceiver $receiver
     * @return void
     */
    public function uploadAddtionalResources($candidat_id, FileReceiver $receiver)
    {

        // receive the file
        $save = $receiver->receive();

        if ($save->isFinished()) {
            $candidat = Candidat::find($candidat_id);
            $candidat->addMedia($save->getFile())->toMediaCollection('resources');
            $resource = $candidat->getMedia('resources')->first();
            return response()->json([
                'message' => 'File uploaded successfully',
                'file_name' => $resource->file_name,
                'size' => $resource->human_readable_size,
                'type' => $resource->mime_type,
                'path' => $resource->getUrl(),
            ]);
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
        ]);

    }

    /**
     * Add Media categories
     *
     */
    public function addMediaCategory(Request $request) {
        $media = Media::find($request->media_id);
        $media->setCustomProperty('categories', $request->category);
        $media->save();
        flash('Category has been added successfully')->success();
        return back();
    }

    /**
     * Update the profile picture of candidat
     *
     */
    public function updateAvatar($candidat_id, Request $request)
    {
        $candidat = Candidat::find($candidat_id);

        if($request->has('file')){
            $candidat->addMediaFromRequest('file')->toMediaCollection('avatar');
        }

        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Get media categories
     *
     */
    public function getMediaCategories(Request $request) {
        $media_cats = Media::find($request->media_id)->getCustomProperty('categories');
        return $media_cats;
    }

    /**
     * Delete media of a candidat
     *
     */
    public function removeMedia(Request $request)
    {
        $media = Media::find($request->mediaid);
        $media->delete();
        flash('File has been deleted successfully')->success();
        return Redirect::to($request->redirect_to);
    }

    /**
     * Delete candidat
     *
     */
    public function remove(Request $request){
        Candidat::find($request->candidat_id)->delete();
        flash("L'candidat a été supprimé avec succès")->success();
        return Redirect::to($request->redirect_to);
    }
}
