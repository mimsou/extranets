<?php


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('/candidats', 'CandidatController');
Route::resource('/projets', 'ProjetController');
Route::resource('/regroupements', 'RegroupementController');
Route::resource('/employeurs', 'EmployeurController');
Route::resource('/utilisateurs', 'UserController');

Route::post('/projets/{id}/addCandidat', 'ProjetController@addCandidat');
Route::get('/projets/{id}/removeCandidat/{candidat_id}', 'ProjetController@removeCandidat');


//Système de gestion - API AJAX Datatables
Route::prefix('api/datatables')->group(function () {
	Route::get('/get-candidats', 'DatatablesController@getCandidats');
	Route::get('/get-projets', 'DatatablesController@getProjets');
	Route::get('/get-regroupements', 'DatatablesController@getRegroupements');
	Route::get('/get-users', 'DatatablesController@getUsers');
	Route::get('/get-employeurs', 'DatatablesController@getEmployeurs');
});


// Route::get('/users', function () {
//     return view('users');
// })->name('users');
