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

Route::get('/', 'PortalController@index')->name('home');

/**
 * Admin Routes
 */

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function(){
    // Show Admin Dashboard after login into admin panel
    Route::get('', 'AdminController@index')->name('admin');

    Route::get('log', 'LogController@index')->name('log');

    Route::resource('users', 'UserController');

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
        // assigning and managing referees of a match
        Route::get('fixtures/{fixture}/referees/create', 'FixtureController@createRefereeAssignment')->name('createRefereeAssignment');
        Route::post('fixtures/{fixture}/referees', 'FixtureController@storeRefereeAssignment')->name('storeRefereeAssignment');
        Route::get('fixtures/{fixture}/referees/{referee}/edit', 'FixtureController@editRefereeAssignment')->name('editRefereeAssignment');
        Route::patch('fixtures/{fixture}/referees/{referee}', 'FixtureController@updateRefereeAssignment')->name('updateRefereeAssignment');
        Route::delete('fixtures/{fixture}/referees/{referee}', 'FixtureController@destroyRefereeAssignment')->name('destroyRefereeAssignment');


    Route::resource('stadiums', 'StadiumController');
    Route::resource('clubs', 'ClubController');

        // assigning and managing players
        Route::resource('clubs.players', 'PlayerController');
        // assigning and managing contacts
        Route::resource('clubs.contacts', 'ContactController');
        // assigning and managing stadiums
        Route::get('clubs/{club}/stadiums/create', 'ClubController@createStadiumAssignment')->name('createStadiumAssignment');
        Route::post('clubs/{club}/stadiums', 'ClubController@storeStadiumAssignment')->name('storeStadiumAssignment');
        Route::get('clubs/{club}/stadiums/{stadium}/edit', 'ClubController@editStadiumAssignment')->name('editStadiumAssignment');
        Route::patch('clubs/{club}/stadiums/{stadium}', 'ClubController@updateStadiumAssignment')->name('updateStadiumAssignment');
        Route::delete('clubs/{club}/stadiums/{stadium}', 'ClubController@destroyStadiumAssignment')->name('destroyStadiumAssignment');

    Route::resource('positions', 'PositionController');
    Route::resource('referees', 'RefereeController');
    Route::resource('people', 'PersonController');

});

