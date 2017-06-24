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

/**
 * Frontend routes
 */

Auth::routes();

Route::get('/', function () {
    return "hi!";
});

Route::get('/home', 'HomeController@index');

/**
 * Admin Routes
 */

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function(){
    // Show Admin Dashboard after login into admin panel
    Route::get('', 'AdminController@index')->name('admin');

    Route::get('log', 'LogController@index')->name('log');

    Route::resource('competitions', 'CompetitionController');
    Route::resource('divisions', 'DivisionController');
    Route::resource('seasons', 'SeasonController');
    Route::resource('matchweeks', 'MatchweekController');
    Route::resource('fixtures', 'FixtureController');
    Route::resource('stadiums', 'StadiumController');

    Route::resource('clubs', 'ClubController');

});

