<?php


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('/candidats', 'CandidatController');



//Système de gestion - API AJAX Datatables
Route::prefix('api/datatables')->group(function () {
	Route::get('/get-candidats', 'DatatablesController@getCandidats');
});


// Route::get('/users', function () {
//     return view('users');
// })->name('users');
