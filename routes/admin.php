<?php


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('/projets', 'ProjetController');
Route::resource('/employeurs', 'EmployeurController');
Route::post('/employeurs/remove', 'EmployeurController@remove');
Route::post('/projets/remove', 'ProjetController@remove');

Route::resource('/gestion/regroupements', 'RegroupementController');
Route::resource('/gestion/emplois', 'EmploiController');
Route::resource('/gestion/pays', 'PaysController');
Route::resource('/gestion/utilisateurs', 'UserController');

Route::post('/projets/{id}/addCandidat', 'ProjetController@addCandidat');
Route::post('/projets/{id}/addDemande', 'ProjetController@addDemande');
Route::post('/projets/{id}/addDemande/getEmployeurContact', 'ProjetController@getEmployeurContact');
Route::post('/projets/{id}/demandeDetails', 'ProjetController@demandeDetails');
Route::patch('/projets/{id}/editDemande/{demandeid}', 'ProjetController@editDemande');
Route::get('/projets/{id}/removeCandidat/{candidat_id}', 'ProjetController@removeCandidat');
Route::get('/projets/{id}/removeDemande/{demande_id}', 'ProjetController@removeDemande');

Route::resource('/candidats', 'CandidatController');
Route::post('/candidats/{candidat_id}/upload-addtional-reources', 'CandidatController@uploadAddtionalResources');
Route::post('/candidats/media-category', 'CandidatController@addMediaCategory');
Route::post('/candidats/{candidat_id}/update-avatar', 'CandidatController@updateAvatar');
Route::post('/candidats/media-categories', 'CandidatController@getMediaCategories');
Route::post('/candidats/media-remove', 'CandidatController@removeMedia');
Route::post('/candidat/remove', 'CandidatController@remove');

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
