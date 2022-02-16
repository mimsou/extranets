<?php

namespace App\Classes\Utils\Logs;

use Auth;
use Exception;
use App\Classes\Utils\Logs\Log;

trait Loggable
{



    protected static function boot(){
        parent::boot();

        static::updating(function($model){
            $loggable_fields = $model->logFields();
            foreach ($model->getDirty() as $key => $value) {
                if(in_array($key, $loggable_fields) || in_array('*', $loggable_fields)){
                    $model->logThat("L'attribut ".$key.' à été changé pour: '.$value, 'AUTO', 'info');
                }
            }
        });

        static::created(function($model){
            $model->logThat("Nouvel instance créé", 'NEW', 'info');
        });
    }

    public function logFields(){ return []; }

    /**
     * Will log a new entry for the model
     * @param  [String] $message [description]
     * @param  [category] $category [description]
     * @param  [category_class] $category_class [description]
     * @return [void]
     */
    public function logThat($message, $category = null, $category_class = null){
        if(is_null($message) || empty($message))
            throw new Exception("Le message ne peut être vide");

        $log = new Log;
        $log->user_id = $this->log_getUserId();
        $log->model_id = $this->id;
        $log->model_type = $this->log_getModel();
        $log->category = $category;
        $log->category_class = $category_class;
        $log->message = $message;
        $log->ip = $this->log_getIp();
        $log->save();
    }

    /**
     * Get ALL logs by date DESC
     * @param  [Array] $include_category [description]
     * @param  [Array] $exclude_category [description]
     * @return [type]                   [description]
     */
    public function getLogs($include_category = null, $exclude_category = null){

        $logs = Log::where('model_id', '=', $this->id)
                   ->where('model_type', '=', $this->log_getModel())
                   ->whereNotNull('user_id')
                   ->orderBy('created_at', 'DESC');

        if(!is_null($include_category)){
            if(gettype($include_category) != 'Array')
                throw new Exception("Included categories must be provided in an array");

            $logs->whereIn('category', $include_category);
        }

        if(!is_null($exclude_category)){
            if(gettype($exclude_category) != 'Array')
                throw new Exception("Exluded categories must be provided in an array");

            $logs->whereNotIn('category', $exclude_category);
        }

        return $logs->get();
    }


    /**
     * Get ALL logs by date DESC
     * @param  [Array] $include_category [description]
     * @param  [Array] $exclude_category [description]
     * @return [type]                   [description]
     */
    public function getLogsForUser($user_id, $qty = 100, $include_category = null, $exclude_category = null){

        $logs = Log::where('user_id', '=', $user_id)
                   ->orderBy('created_at', 'DESC')
                   ->limit($qty);

        if(!is_null($include_category)){
            if(gettype($include_category) != 'Array')
                throw new Exception("Included categories must be provided in an array");

            $logs->whereIn('category', $include_category);
        }

        if(!is_null($exclude_category)){
            if(gettype($exclude_category) != 'Array')
                throw new Exception("Exluded categories must be provided in an array");

            $logs->whereNotIn('category', $exclude_category);
        }

        return $logs->get();
    }


    /**
     * Retreive user id if it's a logged in user
     * @return [int]
     */
    private function log_getUserId(){
        if(Auth::guest()) return null;
        return Auth::user()->id;
    }


    /**
     * Retreive the class name of the model
     * @return [String]
     */
    private function log_getModel(){
        return get_class($this);
    }


    /**
     * Retreive end user IP
     * @return [String]
     */
    private function log_getIp(){
        $ipaddress = '';
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $ipaddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
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


}
