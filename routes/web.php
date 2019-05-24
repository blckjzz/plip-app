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

Route::get('/', function () {
    return view('layouts.home');
})->middleware('auth');

route::prefix('admin', ['middleware' => ['auth', 'isAdmin']])->group(function () {
    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/petition', 'PetitionController@index');
    Route::get('/typeform/getAnwsers', 'TypeformController@getTypeformAnswers');
    Route::get('petition/details/{id}', 'PetitionController@showPetition');
    Route::get('petition/edit/{id}', 'PetitionController@edit');
    Route::get('/petition/assign', 'PetitionController@assign');
    Route::post('/petition/assign', 'PetitionController@saveAssign');
    Route::post('/petition/save', 'PetitionController@save');
//    Route::get('/petition/sync', 'PetitionController@syncPlips');
    Route::get('/petition/in-analysis', 'PetitionController@showPetitionsInAnalysis');
    Route::get('/petition/new-petitions', 'PetitionController@showNewPetitions');
//    Route::get('/trello/info', 'TrelloController@getTrelloBoardInfos');
//    Route::get('/trello/create', 'TrelloController@createTrelloCard');
//    Route::get('/trello/push', 'TrelloController@pushPlipToTrello');
    Route::resource('/voluntarios', 'VolunteerController');
});


route::middleware(['auth', 'isVolunteer'])->prefix('voluntario')->group(function () {
//    Route::resource('/analise', 'AnalysisController');
    Route::get('/peticao/detalhe/{id}', 'VolunteerController@viewPetitionDetails');
    Route::get('/analise/criar/{petition_id}', 'AnalysisController@create');
    Route::GET('/adotar', 'VolunteerController@getSelfAssignView');
    Route::GET('/adotar/{id}', 'VolunteerController@saveSelfAssign');
    Route::GET('/minhas-analises', 'VolunteerController@getAnalisesView');
    Route::GET('/analise/{id}', 'VolunteerController@getAnaliseView');
    Route::POST('/salvar-analise', 'VolunteerController@cadastraAnalise');
});

