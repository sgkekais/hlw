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

/*******************************************************
 * Frontend routes
 ******************************************************/

Auth::routes();
// user verification
Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');

Route::get('/', 'PagesController@index')->name('home');

// division details
Route::get('division/{division}', 'DivisionController@index')->name('frontend.divisions.show');
Route::get('division/{division}/tables', 'DivisionController@tables')->name('frontend.divisions.tables');
Route::get('division/{division}/tables/ajax-full-table', 'DivisionController@ajaxGetFullTable');
Route::get('division/{division}/tables/ajax-home-table', 'DivisionController@ajaxGetHomeTable');
Route::get('division/{division}/tables/ajax-away-table', 'DivisionController@ajaxGetAwayTable');
Route::get('division/{division}/tables/ajax-cross-table', 'DivisionController@ajaxGetCrossTable');
Route::get('division/{division}/fixtures', 'DivisionController@fixtures')->name('frontend.divisions.fixtures');
Route::get('division/{division}/fixtures/ajax-fixtures', 'DivisionController@ajaxGetFixtures');
Route::get('division/{division}/sinners', 'DivisionController@sinners')->name('frontend.divisions.sinners');
Route::get('division/{division}/sinners/ajax-sinners', 'DivisionController@ajaxGetSinners');
Route::get('division/{division}/scorers', 'DivisionController@scorers')->name('frontend.divisions.scorers');
Route::get('division/{division}/scorers/ajax-scorers', 'DivisionController@ajaxGetScorers');

// list all clubs of a season
Route::get('season/{season}/clubs', 'ClubController@index')->name('frontend.seasons.clubs');

// clubs
Route::get('clubs/{club}', 'ClubController@show')->name('frontend.clubs.show');
Route::get('clubs/{club}/ajax-club-results', 'ClubController@ajaxGetClubResults');

// fixtures
Route::get('fixtures/{fixture}', 'FixtureController@show')->name('frontend.fixtures.show');

// user profile
Route::group(['middleware' => ['auth', 'isVerified']], function() {
    Route::get('profile', 'AccountController@profile')->name('frontend.user.profile.show');
    Route::post('profile', 'AccountController@update')->name('frontend.user.profile.update');
    Route::post('profile/clubs', 'AccountController@addClubFavorite')->name('frontend.user.profile.club.add');
    Route::delete('profile/clubs/{club}', 'AccountController@deleteClubFavorite')->name('frontend.user.profile.club.delete');
});

// archive
    Route::get('archive', 'ArchiveController@index')->name('frontend.archive.index');
    // hall of fame
    Route::get('halloffame', 'ArchiveController@hallOfFame')->name('frontend.static.halloffame');
    // former clubs
    Route::get('formerclubs', 'ArchiveController@formerClubs')->name('frontend.archive.formerclubs');

// static
Route::get('imprint', 'PagesController@imprint')->name('frontend.static.imprint');
Route::get('infos', 'PagesController@infos')->name('frontend.static.infos');
Route::get('matchreport', 'PagesController@matchReport')->name('frontend.static.matchreport');
Route::get('datenschutz', 'PagesController@datenschutz')->name('frontend.static.datenschutz');



/*******************************************************
 * Admin Routes
 * these routes are protected by the laravel auth and a custom isAdmin middleware
 ******************************************************/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'isAdmin']], function(){
    // Show Admin Dashboard after login into admin panel
    Route::get('', 'AdminController@index')->name('admin');
    // Log
    Route::get('log', 'LogController@index')->name('log');
    // Calendar TODO: fix memory overload
    Route::get('calendar', 'CalendarController@index')->name('calendar');
    // Docs
    Route::get('docs', 'AdminController@docs')->name('docs');
    // User, role and permissions management
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    // Competitions
    Route::resource('competitions', 'CompetitionController');
    // Divisions
    Route::resource('divisions', 'DivisionController');
    // Seasons
    Route::resource('seasons', 'SeasonController');
    // Assigning clubs to seasons
    Route::get('seasons/{season}/clubs/create', 'SeasonController@createClubAssignment')->name('createClubAssignment');
    Route::post('seasons/{season}/clubs', 'SeasonController@storeClubAssignment')->name('storeClubAssignment');
    Route::get('seasons/{season}/clubs/{club}/edit', 'SeasonController@editClubAssignment')->name('editClubAssignment');
    Route::patch('seasons/{season}/clubs/{club}', 'SeasonController@updateClubAssignment')->name('updateClubAssignment');
    Route::delete('seasons/{season}/clubs/{club}', 'SeasonController@destroyClubAssignment')->name('destroyClubAssignment');
    // Matchweek crud, all matchweek routes are handled with a specific season
    Route::resource('seasons.matchweeks', 'MatchweekController');
    // Csv import of matchweeks
    Route::post('seasons/{season}/matchweeks/import', 'MatchweekController@importCSV')->name('seasons.matchweeks.import');
    // Rescheduling of matches
    Route::get('matchweeks/{matchweek}/fixtures/{fixture}/create', 'FixtureController@create')->name('reschedule.create');
    // Fixtures crud, all fixtures routes are handled with a specific matchweek
    Route::resource('matchweeks.fixtures', 'FixtureController');
    // Fixtures overview
    Route::get('fixtures', 'FixtureController@index')->name('fixtures.index');
    // Fixture import
    Route::post('fixtures/import', 'FixtureController@importCSV')->name('fixtures.import');
    // Managing cards of a match
    Route::resource('fixtures.cards', 'CardController', [
        'except' => 'index'
    ]);
    Route::get('cards', 'CardController@index')->name('cards.index');
    // Managing goals of a match
    Route::resource('fixtures.goals', 'GoalController');
    // Assigning and managing referees of a match
    Route::get('fixtures/{fixture}/referees/create', 'FixtureController@createRefereeAssignment')->name('createRefereeAssignment');
    Route::post('fixtures/{fixture}/referees', 'FixtureController@storeRefereeAssignment')->name('storeRefereeAssignment');
    Route::get('fixtures/{fixture}/referees/{referee}/edit', 'FixtureController@editRefereeAssignment')->name('editRefereeAssignment');
    Route::patch('fixtures/{fixture}/referees/{referee}', 'FixtureController@updateRefereeAssignment')->name('updateRefereeAssignment');
    Route::delete('fixtures/{fixture}/referees/{referee}', 'FixtureController@destroyRefereeAssignment')->name('destroyRefereeAssignment');
    Route::post('fixtures/{fixture}/matchreport', 'FixtureController@storeMatchReport')->name('fixtures.matchreport.store');
    Route::delete('fixtures/{fixture}/matchreport', 'FixtureController@deleteMatchReport')->name('fixtures.matchreport.delete');
    // Stadiums
    Route::resource('stadiums', 'StadiumController');
    Route::post('stadiums/import', 'StadiumController@importCSV')->name('stadiums.import');
    // Clubs
    Route::resource('clubs', 'ClubController');
    // Csv import of clubs
    Route::post('clubs/import', 'ClubController@importCSV')->name('clubs.import');
    // Assigning and managing players
    Route::resource('clubs.players', 'PlayerController');
    // Assigning and managing contacts
    Route::resource('clubs.contacts', 'ContactController');
    // Assigning and managing stadiums
    Route::get('clubs/{club}/stadiums/create', 'ClubController@createStadiumAssignment')->name('createStadiumAssignment');
    Route::post('clubs/{club}/stadiums', 'ClubController@storeStadiumAssignment')->name('storeStadiumAssignment');
    Route::get('clubs/{club}/stadiums/{stadium}/edit', 'ClubController@editStadiumAssignment')->name('editStadiumAssignment');
    Route::patch('clubs/{club}/stadiums/{stadium}', 'ClubController@updateStadiumAssignment')->name('updateStadiumAssignment');
    Route::delete('clubs/{club}/stadiums/{stadium}', 'ClubController@destroyStadiumAssignment')->name('destroyStadiumAssignment');
    // Positions
    Route::resource('positions', 'PositionController');
    // Official divisions
    Route::resource('divisions-official', 'DivisionOfficialController');
    // Referees
    Route::resource('referees', 'RefereeController');
    // People
    Route::resource('people', 'PersonController');

});

