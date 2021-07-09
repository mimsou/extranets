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
    ['progression' => '0%', 'val' => 'rencontre_projet', 'title' => 'Rencontre de démarrage de projet'],
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


!defined('STATUTS_DEMANDE_REC') && define('STATUTS_DEMANDE_REC', [
    ['progression' => '3%', 'val' => 'reception_os_signee', 'title' => "Réception de l'OS signée (IE & Client)"],
    ['progression' => '5%', 'val' => 'reunion_demarrage', 'title' => 'Réunion de démarrage du projet'],
    ['progression' => '7%', 'val' => 'definition_besoins', 'title' => "Définition du besoin détaillé avec le client"],
    ['progression' => '10%', 'val' => 'creation_projet_mission', 'title' => "Création du projet / mission"],
    ['progression' => '15%', 'val' => 'affichage_poste', 'title' => "Affichage des postes et recherches de candidatures"],
    ['progression' => '17%', 'val' => 'confirmation_logistique', 'title' => "Confirmation finale de la logistique de mission"],
    ['progression' => '20%', 'val' => 'analyse_candidatures', 'title' => "Analyse des candidatures (validation des cibles à atteindre)"],
    ['progression' => '30%', 'val' => 'entretiens_tel', 'title' => "Entretien téléphonique (QT)"],
    ['progression' => '35%', 'val' => 'convication', 'title' => "Convocation des candidats"],
    ['progression' => '50%', 'val' => 'mission_rec_entrevue', 'title' => "Mission de recrutement / entrevue de sélection"],
    ['progression' => '60%', 'val' => 'mission_rec_test', 'title' => "Mission de recrutement / test théoriques et pratiques"],
    ['progression' => '65%', 'val' => 'debriefing_mission', 'title' => "Débriefing de mission"],
    ['progression' => '70%', 'val' => 'preparation_dossiers', 'title' => "Préparation des dossiers de candidatures retenus"],
    ['progression' => '75%', 'val' => 'selection_finale', 'title' => "Sélection finale des candidats"],
    ['progression' => '80%', 'val' => 'document_candidat', 'title' => "Cueillette des documents du candidat"],
    ['progression' => '95%', 'val' => 'signature_contrats', 'title' => "Signature des contrats de travail"],
    ['progression' => '100%', 'val' => 'transfert_imm', 'title' => "Transfert des dossiers à l’immigration"],
    ['progression' => '0%', 'val' => 'annule', 'title' => 'Dossier suspendu/annulé'],
]);


/**
 * Manage the DEMANDE status globally
 * @param  [FLOAT]  $version Version to compare
 * @return boolean          [description]
 */
if (!function_exists('demandeStatuts')) {

    function demandeStatuts($key = null, $target=null){
        if(is_null($target)) $target = STATUTS_DEMANDE;

        $select_array = [];
        foreach ($target as $value) {
            if(!is_null($key) && $value['val'] == $key) return $value['title'];

            $select_array[$value['val']] = $value['title'];
        }
        return (!is_null($key))? 'NA' : $select_array;
    }

    function demandeStatutsDate($key = null, $target=null){
        if(is_null($target)) $target = STATUTS_DEMANDE;

        $select_array = [];
        foreach ($target as $value) {
            if(!is_null($key) && $value['val'] == $key) return $value['title'];

            $select_array[$value['val']] = $value['title'];
        }
        return (!is_null($key))? 'NA' : $select_array;
    }

    function demandeProgression($val, $target=null){
        if(is_null($target)) $target = STATUTS_DEMANDE;

        foreach ($target as $value) {
            if($val == $value['val']) return $value['progression'];
        }

        return 0;
    }
}


!defined('STATUTS_PERMIS_TRAVAIL') && define('STATUTS_PERMIS_TRAVAIL', [
    ['progression' => '0%', 'val' => 'offre_signee', 'title' => 'Demande non débutée'],
    // ['progression' => '10%', 'val' => 'offre_creee', 'title' => "Offre d'emploi créée (Mob. fr.)"],
    ['progression' => '25%', 'val' => 'pt_encours', 'title' => 'Permis en préparation'],
    // ['progression' => '15%', 'val' => 'attente_antecedant', 'title' => "En attente d'antécédants"],
    // ['progression' => '30%', 'val' => 'qa_pt', 'title' => 'Contrôle qualité permis de travail'],
    // ['progression' => '80%', 'val' => 'pt_envoye', 'title' => 'Permis de travail envoyé'],
    ['progression' => '80%', 'val' => 'pt_depose', 'title' => 'Demande soumise'],
    ['progression' => '90%', 'val' => 'pt_obtenu', 'title' => 'Demande approuvée'],
    ['progression' => '100%', 'val' => 'pt_archive', 'title' => 'Copie du permis archivée'],
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

        if(!is_null($key)) return 'Non-applicable';

        return $select_array;
    }

    function permisTravailProgression($val){
        foreach (STATUTS_PERMIS_TRAVAIL as $value) {
            if($val == $value['val']) return $value['progression'];
        }

        return '0%';
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



/**
 * Retourne les projets en recrutement avec une date de création mais pas de date de sélection
 */
if (!function_exists('rec_projetsencours')) {
    function rec_projetsencours()
    {
        $projet_dates = \App\Models\Projet::whereNotNull('date_creation')
                                 ->whereNull('date_selection')
                                 ->where('statut', 'LIKE', 'rec_%')
                                 ->whereNotIn('statut', ['new_projet'])
                                 ->orderBy('date_creation', 'ASC')
                                 ->get();

        $demande_incomplete = \App\Models\Demande::where('type', 'recrutement')
                                                 ->whereRaw('nb_candidat > nb_candidat_recrute')
                                                 ->whereNotIn('statut', ['annule'])
                                                 ->select('projet_id')
                                                 ->get();

        $projet_incomplets = \App\Models\Projet::whereNotNull('date_creation')
                                                ->where('statut', 'LIKE', 'rec_%')
                                                ->whereNotIn('statut', ['new_projet'])
                                                ->whereIn('id', $demande_incomplete)
                                                ->orderBy('date_creation', 'ASC')
                                                ->get();

        return $projet_dates->merge($projet_incomplets)->unique();


    }
}



/**
 * Retourne les demandes en immigration datant de plus d'un mois sans date d'envoi de l'EIMT
 */
if (!function_exists('imm_demandeEIMT')) {
    function imm_demandeEIMT()
    {
        $demandes = DB::table('demandes AS d')
                                       ->join('projets AS p', 'p.id', '=', 'd.projet_id')
                                       ->join('employeurs AS e', 'e.id', '=', 'p.employeur_id')
                                       ->select(['p.numero', 'p.id', 'e.nom', 'p.date_creation'])
                                       ->where('p.date_creation', '<', \Carbon\Carbon::now()->subMonth())
                                       ->whereNull('d.eimt_date_envoi')
                                       ->whereNotIn('d.statut', ['annule'])
                                       ->whereNotIn('p.statut', ['new_projet'])
                                       ->where('d.type', 'LIKE', 'imm_%')
                                       ->orderBy('date_creation', 'ASC')
                                       ->get()->unique();

        return $demandes;
    }
}


/**
 * Retourne les demandes envoyées mais sans date de réception, en traitement depuis plus de 4 mois
 */
if (!function_exists('imm_demandeEIMT_enattente')) {
    function imm_demandeEIMT_enattente($months)
    {
        $demandes = DB::table('demandes AS d')
                                       ->join('projets AS p', 'p.id', '=', 'd.projet_id')
                                       ->join('employeurs AS e', 'e.id', '=', 'p.employeur_id')
                                       ->select(['p.numero', 'p.id', 'e.nom', 'p.date_creation', 'd.eimt_date_envoi'])
                                       ->where('d.eimt_date_envoi', '<', \Carbon\Carbon::now()->subMonths($months))
                                       ->whereNull('d.eimt_date_reception')
                                       ->whereNotIn('d.statut', ['annule'])
                                       ->whereNotIn('p.statut', ['new_projet'])
                                       ->where('d.type', 'LIKE', 'imm_%')
                                       ->orderBy('date_creation', 'ASC')
                                       ->get()->unique();

        return $demandes;
    }
}



/**
 * Retourne les demandes en immigration ayant une EIMT datant de plus de 14 jours mais sans date d'envoi du permis de travail
 */
if (!function_exists('imm_demandePermisTravail')) {
    function imm_demandePermisTravail()
    {
        $demandes = DB::table('demandes AS d')
                                       ->join('projets AS p', 'p.id', '=', 'd.projet_id')
                                       ->join('employeurs AS e', 'e.id', '=', 'p.employeur_id')
                                       ->join('demande_candidat AS dc', 'dc.demande_id', '=', 'd.id')
                                       ->join('candidats AS c', 'dc.candidat_id', '=', 'c.id')
                                       ->select(['p.numero', 'd.projet_id', 'e.nom', 'p.date_creation'])
                                       ->where('d.eimt_date_envoi', '<', \Carbon\Carbon::now()->subDays(14))
                                       ->where('dc.statut', 'approved')
                                       ->whereNull('c.permis_date_envoi')
                                       ->whereNotIn('c.statut_pt', ['na', 'pt_suspendu', 'pt_refuse'])
                                       ->where('d.type', 'LIKE', 'imm_%')
                                       ->get()->unique();



        return $demandes;
    }
}



/**
 * Retourne les demandes en immigration ayant une EIMT datant de plus de 14 jours mais sans date d'envoi du permis de travail
 */
if (!function_exists('imm_demandePermisTravail_enattente')) {
    function imm_demandePermisTravail_enattente($months)
    {
        $demandes = DB::table('demandes AS d')
                                       ->join('projets AS p', 'p.id', '=', 'd.projet_id')
                                       ->join('employeurs AS e', 'e.id', '=', 'p.employeur_id')
                                       ->join('demande_candidat AS dc', 'dc.demande_id', '=', 'd.id')
                                       ->join('candidats AS c', 'dc.candidat_id', '=', 'c.id')
                                       ->select(['p.numero', 'd.projet_id', 'e.nom', 'p.date_creation', 'c.permis_date_envoi', 'c.nom AS name', 'c.id AS c_id'])
                                       ->where('c.permis_date_envoi', '<', \Carbon\Carbon::now()->subMonths(3))
                                       ->where('dc.statut', 'approved')
                                       ->whereNull('c.permis_date_reception')
                                       ->whereNotIn('c.statut_pt', ['na', 'pt_suspendu', 'pt_refuse'])
                                       ->where('d.type', 'LIKE', 'imm_%')
                                       ->get()->unique();



        return $demandes;
    }
}

/**
 * Send email only if App is in production env
 * or if emails belongs to devs
 *
 * @param [string] $email
 * @return boolean return true if app is in production env OR if emails belongs to devs
 */
if(!function_exists('sendEmailEnv')){
    function sendEmailEnv($email) {
        return env('APP_ENV') == 'production' || $email == 'micbhatti@gmail.com';
    }
}

if(!function_exists('isMineMessage')){
    function isMineMessage($userId){
        return ($userId == Auth::user()->id);
    }
}


if(!function_exists('is_associate_user')){
    function is_associate_user(){
        $userRole = \Auth::user()->role_lvl;
        if($userRole > 1 && $userRole < 3){
            return true;
        }else{
            return false;
        }
    }
}


if(!function_exists('is_employeur_user')){
    function is_employeur_user(){
        $userRole = \Auth::user()->role_lvl;
        if($userRole == 3){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('is_admin_user')){
    function is_admin_user(){
        $userRole = \Auth::user()->role_lvl;
        if($userRole == 10){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('it_has_project')){
    function it_has_project($projectId){
        $userId = \Auth::user()->id;
        $assocUser = \App\Models\AssocUserMap::where(['user_id'=>$userId])->first();
        if($assocUser == null){
            return false;
        }
        $projectDetails = \App\Models\Projet::find($projectId);
        $employerDetails = \App\Models\Employeur::where(['regroupement_id'=>$assocUser->group_id])->pluck('id')->toArray();
        if(in_array($projectDetails->employeur_id,$employerDetails)){
            return true;
        }else{
            return false;
        }
    }
}


if(!function_exists('it_has_demande')){
    function it_has_demande($demandeId){
        $userId = \Auth::user()->id;
        $assocUser = \App\Models\AssocUserMap::where(['user_id'=>$userId])->first();
        if($assocUser == null){
            return false;
        }

        $demandeDetails = \App\Models\Demande::find($demandeId);
        $employerDetails = \App\Models\Employeur::where(['regroupement_id'=>$assocUser->group_id])->pluck('id')->toArray();
        if(in_array($demandeDetails->employeur_id,$employerDetails)){
            return true;
        }else{
            return false;
        }
    }
}
