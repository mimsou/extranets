<?php



/**
 * Check if the version # passed in param. is = to the app version.
 * @param  [FLOAT]  $version Version to compare
 * @return boolean          [description]
 */
if (!function_exists('isThisANewFeature')) {
    function isThisANewFeature($version)
    {
        if(floatval(env('APP_VERSION')) == $version) return true;
        return false;
    }

    function getIsNewFeatureHTML(){
        return '<span class="icon-badge badge-success badge badge-pill">NEW</span>';
    }
}



/**
 * Retourne la classe active lorsque l'URL match le path
 * @param  str      $path URL à comparer
 * @return str      la classe active si il y a un match
 */
if (!function_exists('classActivePath')) {
    function classActivePath($path)
    {

        return (Request::url() == $path) ? ' active' : '';
    }
}



/**
 * Retourne la classe active lorsque le texte est présent dans un des segments de l'URL
 * @param  int      segment URL à comparer
 * @param  str      string URL à comparer
 * @return str      la classe active si il y a un match
 */
if (!function_exists('classActiveSegment')) {
    function classActiveSegment($segment, $value, $withchild = false)
    {
        $opened = '';
        if($withchild) $opened = 'opened';

        if(!is_array($value)) {
            return Request::segment($segment) == $value ? 'active '.$opened : '';
        }
        foreach ($value as $v) {
            if(Request::segment($segment) == $v) return 'active '.$opened;
        }
        return '';
    }
}



/**
 * Retourne le chemin de la version anglaise pour l'admin
 */
if (!function_exists('switchLangURL')) {
    function switchLangURL()
    {
        $domain = '';
        if(Lang::getLocale() == 'fr'){
            $domain = env('APP_URL_EN');
        }elseif(Lang::getLocale() == 'en'){
            $domain = env('APP_URL_FR');
        }
        return 'http://'.$domain.$_SERVER['REQUEST_URI'];
    }
}


/**
 * Retourne la langue du switch
 */
if (!function_exists('switchLang')) {
    function switchLang()
    {
        if(Lang::getLocale() == 'fr'){
            return 'EN';
        }elseif(Lang::getLocale() == 'en'){
            return 'FR';
        }
    }
}


// Function to get the client IP address
if (!function_exists('get_client_ip')) {
    function get_client_ip() {
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

