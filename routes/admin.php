<?php


Route::get('/', function () {
    if(Auth::user() && Auth::user()->role_lvl == 3) { //user is employer
        $employeur = \App\Models\Employeur::find(Auth::user()->employeur_id);
        return view('admin.employeurs.edit', compact('employeur'));
    }
    return view('dashboard');
})->name('dashboard');

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

Route::resource('/candidats', 'CandidatController');
Route::post('/candidats/{candidat_id}/upload-addtional-reources', 'CandidatController@uploadAddtionalResources');
Route::post('/candidats/media-category', 'CandidatController@addMediaCategory');
Route::post('/candidats/{candidat_id}/update-avatar', 'CandidatController@updateAvatar');
Route::post('/candidats/media-categories', 'CandidatController@getMediaCategories');
Route::post('/candidats/media-remove', 'CandidatController@removeMedia');
Route::post('/candidat/remove', 'CandidatController@remove');

//Ajax Route
Route::post('remove/assignee','DemandeController@removeAssignee');

//Système de gestion - API AJAX Datatables
Route::prefix('api/datatables')->group(function () {
	Route::get('/get-candidats', 'DatatablesController@getCandidats');
	Route::get('/get-projets', 'DatatablesController@getProjets');
	Route::get('/get-regroupements', 'DatatablesController@getRegroupements');
	Route::get('/get-users', 'DatatablesController@getUsers');
	Route::get('/get-employeurs', 'DatatablesController@getEmployeurs');
	Route::get('/get-emplois', 'DatatablesController@getEmplois');
	Route::get('/get-pays', 'DatatablesController@getPays');
});




// Route::get('/users', function () {
//     return view('users');
// })->name('users');
