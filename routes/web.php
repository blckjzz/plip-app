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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () {
    return view('layouts.home');
})->middleware('auth');

Route::get('/petition', 'PetitionController@index');
Route::get('/typeform/getAnwsers', 'TypeformController@getTypeformAnswers');
Route::get('petition/details/{id}', 'PetitionController@showPetition');
Route::get('petition/edit/{id}', 'PetitionController@edit');
Route::get('/petition/assign', 'PetitionController@assign');
Route::post('/petition/assign', 'PetitionController@saveAssign');
Route::post('/petition/save', 'PetitionController@save');
Route::get('/petition/sync', 'PetitionController@syncPlips');
Route::get('/petition/in-analysis', 'PetitionController@showPetitionsInAnalysis');
Route::get('/petition/new-petitions', 'PetitionController@showNewPetitions');
Route::get('/trello/info', 'TrelloController@getTrelloBoardInfos');
Route::get('/trello/create', 'TrelloController@createTrelloCard');
Route::get('/trello/push', 'TrelloController@pushPlipToTrello');
Route::resource('/voluntarios', 'VolunteerController');










Route::get('/home', 'HomeController@index')->name('home');
