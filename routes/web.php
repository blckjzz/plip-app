<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
//Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('admin', function () {
    return view('layouts.home');
})->middleware(['isAdmin', 'auth']);

route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/petition', 'PetitionController@index');
    Route::get('/typeform/getAnwsers', 'TypeformController@getTypeformAnswers');
    Route::get('petition/details/{id}', 'PetitionController@showPetition');
    Route::get('petition/edit/{id}', 'PetitionController@edit');
    Route::get('/petition/assign', 'PetitionController@assign');
    Route::post('/petition/assign', 'PetitionController@saveAssign');
    Route::post('/petition/save', 'PetitionController@save');
    Route::get('/petition/in-analysis', 'PetitionController@showPetitionsInAnalysis');
    Route::get('/petition/new-petitions', 'PetitionController@showNewPetitions');
    Route::GET('/voluntarios/criar', 'VolunteerController@create');
    Route::GET('/voluntarios/lista', 'VolunteerController@index');
    Route::POST('/voluntarios/salvar', 'VolunteerController@store');
    Route::GET('/voluntarios/ver/{id}', 'VolunteerController@show');
    Route::GET('/voluntarios/editar/{id}', 'VolunteerController@edit');
});


route::middleware(['auth', 'isVolunteer'])->prefix('voluntario')->group(function () {

    Route::get('/', 'DashboardController@getCardValues');
    Route::get('/peticao/detalhe/{id}', 'VolunteerController@viewPetitionDetails');
    Route::get('/analise/criar/{petition_id}', 'AnalysisController@create');
    Route::GET('/adotar', 'VolunteerController@getSelfAssignView');
    Route::GET('/adotar/{id}', 'VolunteerController@saveSelfAssign');
    Route::GET('/minhas-analises', 'VolunteerController@getAnalisesView');
    Route::GET('/analise/{id}', 'VolunteerController@getAnaliseView');
    Route::POST('/salvar-analise', 'VolunteerController@cadastraAnalise');
});

