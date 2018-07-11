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
    return view('welcome');
});

Route::get('/petition', 'PetitionController@index');
Route::get('/typeform/getAnwsers', 'TypeformController@getTypeformAnswers');
Route::get('petition/details/{id}', 'PetitionController@showPetition');
Route::get('petition/edit/{id}', 'PetitionController@edit');
Route::POST('/petition/save', 'PetitionController@save');
Route::get('/petition/sync', 'PetitionController@syncPlips');
Route::get('/trello/info', 'TrelloController@getTrelloBoardInfos');
Route::get('/trello/create', 'TrelloController@createTrelloCard');
Route::get('/trello/push', 'TrelloController@pushPlipToTrello');
Route::resource('/volunteer', 'VolunteerController');
