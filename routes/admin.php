<?php


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('/candidats', 'CandidatController');
Route::resource('/projets', 'ProjetController');
Route::resource('/employeurs', 'EmployeurController');
Route::post('/employeurs/remove', 'EmployeurController@remove');
Route::post('/projets/remove', 'ProjetController@remove');

Route::resource('/gestion/regroupements', 'RegroupementController');
Route::resource('/gestion/emplois', 'EmploiController');
Route::resource('/gestion/pays', 'PaysController');
Route::resource('/gestion/utilisateurs', 'UserController');

Route::post('/projets/{id}/addCandidat', 'ProjetController@addCandidat');
Route::get('/projets/{id}/removeCandidat/{candidat_id}', 'ProjetController@removeCandidat');


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
