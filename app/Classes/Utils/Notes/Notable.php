<?php

namespace App\Classes\Utils\Notes;

use Auth;
use Exception;
use App\Classes\Utils\Notes\Note;

/**
 * Trait Notable
 * @package App\Classes\Utils\Notes
 */
trait Notable
{


    /**
     * Will log a new entry for the model
     * @param  [String] $message [description]
     * @param  [category] $category [description]
     * @param  [category_class] $category_class [description]
     * @return [void]
     */
    public function noteThat($message, $category = null, $category_class = null)
    {
        if(is_null($message) || empty($message))
            throw new Exception("Le message ne peut être vide");

        $log = new Note;
        $log->user_id = $this->note_getUserId();
        $log->model_id = $this->id;
        $log->model_type = $this->note_getModel();
        $log->category = $category;
        $log->category_class = $category_class;
        $log->message = $message;
        $log->ip = $this->note_getIp();
        $log->save();

        return $log;
    }

    /**
     * Get ALL logs by date DESC
     * @param  [Array] $include_category [description]
     * @param  [Array] $exclude_category [description]
     * @return [type]                   [description]
     */
    public function getNotes($include_category = null, $exclude_category = null)
    {

        $notes = Note::where('model_id', '=', $this->id)
            ->where('model_type', '=', $this->note_getModel())
            ->whereNotNull('user_id')
            ->orderBy('created_at', 'ASC');

        if(!is_null($include_category)) {
            if(gettype($include_category) != 'array')
                throw new Exception("Included categories must be provided in an a");

            $notes->whereIn('category', $include_category);
        }

        if(!is_null($exclude_category)) {
            if(gettype($exclude_category) != 'array')
                throw new Exception("Exluded categories must be provided in an array");

            $notes->whereNotIn('category', $exclude_category);
        }

        return $notes->get();
    }


    /**
     * Get ALL logs by date DESC
     * @param  [Array] $include_category [description]
     * @param  [Array] $exclude_category [description]
     * @return [type]                   [description]
     */
    public function getNotesForUser($user_id, $qty = 100, $include_category = null, $exclude_category = null)
    {

        $notes = Note::where('user_id', '=', $user_id)
            ->orderBy('created_at', 'DESC')
            ->limit($qty);

        if(!is_null($include_category)) {
            if(gettype($include_category) != 'Array')
                throw new Exception("Included categories must be provided in an array");

            $notes->whereIn('category', $include_category);
        }

        if(!is_null($exclude_category)) {
            if(gettype($exclude_category) != 'Array')
                throw new Exception("Exluded categories must be provided in an array");

            $notes->whereNotIn('category', $exclude_category);
        }

        return $notes->get();
    }


    /**
     * Retreive user id if it's a logged in user
     * @return [int]
     */
    private function note_getUserId()
    {
        if(Auth::guest()) return null;
        return Auth::user()->id;
    }


    /**
     * Retreive the class name of the model
     * @return [String]
     */
    private function note_getModel()
    {
        return get_class($this);
    }


    /**
     * Retreive end user IP
     * @return [String]
     */
    private function note_getIp()
    {
        $ipaddress = '';
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $ipaddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
        else if(isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    /**
     * Delete note
     * @param $id
     * @return mixed
     */
    public function deleteThat($id)
    {
        return Note::find($id)->delete();
    }
}
