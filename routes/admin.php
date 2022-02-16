<?php


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::user() && Auth::user()->role_lvl == 3) { //user is employer
        $employeur = \App\Models\Employeur::find(Auth::user()->employeur_id);
        return view('admin.employeurs.edit', compact('employeur'));
    }
    if(Auth::user() && is_associate_user()){
        return redirect()->route('employeurs.index');
    }
    return view('dashboard-details');
})->name('dashboard.details');
Route::get('verify/token/{token}', 'TodoController@verifyToken')->name('verify.token');
Route::get('/dashboard','DashboardController@index')->name('dashboard');
//Route::get('/','DashboardController@nosBonsCoups')->name('dashboard.details');

Route::resource('/projets', 'ProjetController');
Route::resource('/employeurs', 'EmployeurController');
Route::post('/employeurs/remove', 'EmployeurController@remove');
Route::get('/employeurs/{id}/users', 'EmployeurController@userManagement');
Route::get('/employeurs/{id}/users/create-user', 'EmployeurController@createUser');
Route::get('/employeurs/{id}/users/{user_id}/edit', 'EmployeurController@editUser');
Route::post('/employeurs/{id}/users/delete', 'EmployeurController@deleteUser');
Route::post('/projets/remove', 'ProjetController@remove');

Route::resource('/gestion/regroupements', 'RegroupementController');
Route::resource('/gestion/emplois', 'EmploiController');
Route::resource('/gestion/pays', 'PaysController');
Route::resource('/gestion/utilisateurs', 'UserController');
Route::post('/gestion/utilisateurs/{id}/saveComment', 'UserController@saveComment');

Route::post('comments/view/all','UserController@getComments');
Route::get('comment/delete/{demande_id}/{comment_id}','UserController@deleteComment')->name('delete.comment');

Route::post('/projets/{id}/addCandidat', 'ProjetController@addCandidat');
Route::post('/projets/{id}/addDemande', 'ProjetController@addDemande');
Route::post('/projets/{id}/addDemande/getEmployeurContact', 'ProjetController@getEmployeurContact');
Route::post('/projets/{id}/demandeDetails', 'ProjetController@demandeDetails');
Route::patch('/projets/{id}/editDemande/{demandeid}', 'ProjetController@editDemande');
Route::get('/projets/{id}/updateCandidat/{candidat_id}/{statut}', 'ProjetController@updateCandidat');
Route::get('/projets/{id}/removeCandidat/{candidat_id}', 'ProjetController@removeCandidat');
Route::get('/projets/{id}/removeDemande/{demande_id}', 'ProjetController@removeDemande');

// assign user to demande
Route::post('/projets/assign-user', 'DemandeController@assingUser');
Route::get('/demande/{demande_id}/mark-completed-incomplete', 'DemandeController@markAsCompletedOrIncomeplete');

//Todo
Route::post('todo/save','TodoController@save');
Route::get('todo/list/{project_id}/{demande_id}','TodoController@todoList');
Route::get('todo/templates/list','TodoController@templatesList');
Route::get('todo/templates/list','TodoController@templatesList');
Route::get('todo/template/create','TodoController@createTemplate');
Route::post('todo/template/save','TodoController@saveTemplate');
Route::get('todo/update/status','TodoController@updateStatus');
Route::post('todo/update/orders','TodoController@updateTodoOrder');
Route::post('todo/from/template','TodoController@createTodoFromTemplate');
Route::post('todo/update/{todo_id}','TodoController@updateTodo');
Route::post('todo/group/create','TodoController@createGroup');
Route::post('todo/assign/user','TodoController@assignUser');
Route::post('todo/remove/assignee','TodoController@removeAssignee');
Route::post('todo/group/update','TodoController@updateTodoGroup');
Route::get('todo/templates','TodoController@manageTemplates');
Route::get('todo/templates/delete/{id}','TodoController@deleteTemplate')->name('delete.template');
Route::get('todo/template/view/{id}','TodoController@viewTemplateContent');
Route::post('todo/template/content/delete','TodoController@deleteTemplateContent');

Route::resource('/candidats', 'CandidatController');
Route::post('/candidats/{candidat_id}/upload-addtional-reources', 'CandidatController@uploadAddtionalResources');
Route::post('/candidats/media-category', 'CandidatController@addMediaCategory');
Route::post('/candidats/{candidat_id}/update-avatar', 'CandidatController@updateAvatar');
Route::post('/candidats/media-categories', 'CandidatController@getMediaCategories');
Route::post('/candidats/media-remove', 'CandidatController@removeMedia');
Route::post('/candidat/remove', 'CandidatController@remove');

//Association user
Route::get('association/users/{assoc_group_id}','AssociationUsersController@index')->name('association.users');
Route::get('association/users/create/{assoc_group_id}','AssociationUsersController@create')->name('association.users.create');
Route::post('association/users/save/{assoc_group_id}','AssociationUsersController@store')->name('association.users.save');
Route::get('association/users/edit/{assoc_group_id}/{user_id}','AssociationUsersController@edit')->name('association.users.edit');
Route::patch('association/users/edit/{assoc_group_id}/{user_id}','AssociationUsersController@update')->name('association.users.update');
Route::post('association/users/remove','AssociationUsersController@remove');

//Ajax Route
Route::post('remove/assignee','DemandeController@removeAssignee');

//Système de gestion - API AJAX Datatables
Route::prefix('api/datatables')->group(function () {
	Route::get('/get-candidats', 'DatatablesController@getCandidats');
	Route::get('/get-projets/{personne?}/{type_de_projet?}/{employeur?}/{statut_du_dossier?}/{isCompletedChecked?}/{isHourlyChecked?}', 'DatatablesController@getProjets');
	Route::get('/get-regroupements', 'DatatablesController@getRegroupements');
	Route::get('/get-users', 'DatatablesController@getUsers');
	Route::get('/get-employeurs', 'DatatablesController@getEmployeurs');
	Route::get('/get-emplois', 'DatatablesController@getEmplois');
	Route::get('/get-pays', 'DatatablesController@getPays');
});


Route::get('/get-dashboard-counts','DashboardController@getCountsByFilter');

// TIME TRACKING
Route::post('projets/{id}/time-tracking', 'TimeTrackingController@store')->name('time_tracking_store');
Route::get('projets/{id}/time-tracking', 'TimeTrackingController@show')->name('time_tracking_show');
Route::get('projets/{projet_id}/time-tracking/{user_id}', 'TimeTrackingController@showDetails')->name('time_tracking_detail_show');
Route::get('time-tracking', 'TimeTrackingController@index')->name('time_tracking_index');
Route::get('flash', 'TimeTrackingController@flash')->name('flash.notifications');
Route::get('time-tracking/get-time-tracking', 'TimeTrackingController@getDatatableContent');

Route::post('/candidats/{candidat_id}/comments','CommentaireController@ajoutAuCandidat')->name('candidat_add_comment');
Route::get('/candidats/{candidat_id}/comments','CommentaireController@getAuCandidat')->name('candidat_get_comment');


// Route::get('/users', function () {
//     return view('users');
// })->name('users');
