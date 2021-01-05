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


!defined('PROCEDURE_DEMANDE') && define('PROCEDURE_DEMANDE', [
    'simplifie' => 'Simplifié',
    'reg_bas_salaire' => 'Reg. Bas salaire',
    'reg_haut_salaire' => 'Reg. Haut salaire',
    'non_determine' => 'Non déterminé',
    'mobilite_franco' => 'Mobilité francophone',
    'jeunes_professionnels' => 'Jeunes professionnels',
]);



!defined('STATUTS_DEMANDE') && define('STATUTS_DEMANDE', [
    ['progression' => '0%', 'val' => 'offre_signee', 'title' => 'Offre de service signée'],
    ['progression' => '0%', 'val' => 'attente_selection', 'title' => 'Attente sélection ou contrats'],
    ['progression' => '5%', 'val' => 'verif_passport', 'title' => 'Vérification des passeports/AVE'],
    ['progression' => '10%', 'val' => 'eimt_encours', 'title' => 'EIMT en cours'],
    ['progression' => '15%', 'val' => 'preuve_recru', 'title' => 'Preuve de recru en cours'],
    ['progression' => '20%', 'val' => 'eimt_envoye_client', 'title' => 'EIMT envoyée au client'],
    ['progression' => '25%', 'val' => 'eimt_qa', 'title' => 'Contrôle qualité EIMT'],
    ['progression' => '30%', 'val' => 'eimt_sc', 'title' => 'EIMT envoyée EDSC'], //Date envoi EIMT
    ['progression' => '40%', 'val' => 'dst_encours', 'title' => 'DST en cours'],
    ['progression' => '50%', 'val' => 'dst_envoye_client', 'title' => 'DST envoyée au client'],
    ['progression' => '70%', 'val' => 'dst_mifi', 'title' => 'DST envoyée MIFI'],
    ['progression' => '80%', 'val' => 'eimt_en_traitement', 'title' => 'EIMT en traitement'],
    ['progression' => '90%', 'val' => 'eimt_dst_en_traitement', 'title' => 'EIMT/DST en traitement'],
    ['progression' => '100%', 'val' => 'acceptation', 'title' => 'Acceptation EIMT/CAQ'], //échéance
    ['progression' => '0%', 'val' => 'annule', 'title' => 'Dossier suspendu/annulé'],
]);


/**
 * Manage the DEMANDE status globally
 * @param  [FLOAT]  $version Version to compare
 * @return boolean          [description]
 */
if (!function_exists('demandeStatuts')) {

    function demandeStatuts($key = null){
        $select_array = [];
        foreach (STATUTS_DEMANDE as $value) {
            if(!is_null($key) && $value['val'] == $key) return $value['title'];

            $select_array[$value['val']] = $value['title'];
        }
        return $select_array;
    }

    function demandeStatutsDate($key = null){
        $select_array = [];
        foreach (STATUTS_DEMANDE as $value) {
            if(!is_null($key) && $value['val'] == $key) return $value['title'];

            $select_array[$value['val']] = $value['title'];
        }
        return $select_array;
    }

    function demandeProgression($val){
        foreach (STATUTS_DEMANDE as $value) {
            if($val == $value['val']) return $value['progression'];
        }
    }
}


!defined('STATUTS_PERMIS_TRAVAIL') && define('STATUTS_PERMIS_TRAVAIL', [
    ['progression' => '0%', 'val' => 'offre_signee', 'title' => 'Offre de service signée'],
    ['progression' => '10%', 'val' => 'offre_creee', 'title' => "Offre d'emploi créée (Mob. fr.)"],
    ['progression' => '15%', 'val' => 'pt_encours', 'title' => 'Permis de travail en cours'],
    ['progression' => '15%', 'val' => 'attente_antecedant', 'title' => "En attente d'antécédants"],
    ['progression' => '30%', 'val' => 'qa_pt', 'title' => 'Contrôle qualité permis de travail'],
    ['progression' => '80%', 'val' => 'pt_envoye', 'title' => 'Permis de travail envoyé'],
    ['progression' => '90%', 'val' => 'pt_depose', 'title' => 'Permis de travail deposé'],
    ['progression' => '100%', 'val' => 'pt_obtenu', 'title' => 'Permis de travail obtenu'],
    ['progression' => '0%', 'val' => 'pt_suspendu', 'title' => 'Permis de travail suspendu/annulé'],
    ['progression' => '0%', 'val' => 'pt_refuse', 'title' => 'Permis de travail refusé'],
]);


/**
 * Manage the DEMANDE status globally
 * @param  [FLOAT]  $version Version to compare
 * @return boolean          [description]
 */
if (!function_exists('permisTravailStatuts')) {

    function permisTravailStatuts($key = null){
        $select_array = [];
        $select_array['na'] = "Non-applicable";
        foreach (STATUTS_PERMIS_TRAVAIL as $value) {
            if(!is_null($key) && $value['val'] == $key) return $value['title'];

            $select_array[$value['val']] = $value['title'];
        }
        return $select_array;
    }

    function permisTravailProgression($val){
        foreach (STATUTS_PERMIS_TRAVAIL as $value) {
            if($val == $value['val']) return $value['progression'];
        }
    }
}

/**
 * Get a list of all media categories in array
 * 
 */
if(!function_exists('mediaCategories')) {
    function mediaCategories() {
        $categories = [];
        $medias = \Spatie\MediaLibrary\MediaCollections\Models\Media::all();
        foreach($medias as $media) {
            if(!is_null($media->getCustomProperty('categories'))) {
                $categories = array_unique(array_merge($categories, $media->getCustomProperty('categories')));
            }
        }
        return array_filter($categories, 'strlen');
    }
}
