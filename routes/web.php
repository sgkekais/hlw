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

Route::get('/', 'PortalController@index');

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

        // assigning clubs to seasons
        Route::get('seasons/{season}/clubs/create', 'SeasonController@createClubAssignment')->name('createClubAssignment');
        Route::post('seasons/{season}/clubs', 'SeasonController@storeClubAssignment')->name('storeClubAssignment');
        Route::get('seasons/{season}/clubs/{club}/edit', 'SeasonController@editClubAssignment')->name('editClubAssignment');
        Route::patch('seasons/{season}/clubs/{club}', 'SeasonController@updateClubAssignment')->name('updateClubAssignment');

    // matchweek crud, all matchweek routes are handled with a specific season
    Route::resource('seasons.matchweeks', 'MatchweekController');
    // rescheduling of matches
    Route::get('matchweeks/{matchweek}/fixtures/{fixture}/create', 'FixtureController@create')->name('reschedule.create');
    // fixtures crud, all fixtures routes are handled with a specific matchweek
    Route::resource('matchweeks.fixtures', 'FixtureController');

        // managing cards of a match
        Route::resource('fixtures.cards', 'CardController');
        // managing goals of a match
        Route::resource('fixtures.goals', 'GoalController');

    Route::resource('stadiums', 'StadiumController');
    Route::resource('clubs', 'ClubController');

        // assigning and managing players
        Route::resource('clubs.players', 'PlayerController');
//        Route::get('clubs/{club}/players/create', 'PlayerController@create')->name('players.create');
//        Route::post('clubs/{club}/players', 'PlayerController@store')->name('players.store');
//        Route::get('clubs/{club}/players/{player}/edit', 'PlayerController@edit')->name('players.edit');
//        Route::patch('clubs/{club}/players/{player}', 'PlayerController@update')->name('players.update');
//        Route::delete('clubs/{club}/players/{player}', 'PlayerController@destroy')->name('players.destroy');

        // assigning and managing contacts
        Route::resource('clubs.contacts', 'ContactController');

    Route::resource('positions', 'PositionController');
    Route::resource('referees', 'RefereeController');
    Route::resource('people', 'PersonController');

});

