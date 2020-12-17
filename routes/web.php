<?php

use App\Events\Event;

Route::redirect('/', 'admin/home');

Auth::routes(['register' => false]);

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::delete('permissions_mass_destroy', 'Admin\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Admin\RolesController');
    Route::delete('roles_mass_destroy', 'Admin\RolesController@massDestroy')->name('roles.mass_destroy');
    Route::resource('users', 'Admin\UsersController');
    Route::delete('users_mass_destroy', 'Admin\UsersController@massDestroy')->name('users.mass_destroy');

    // Main CRUD Operations

    // teams
    Route::resource('teams', 'Admin\Scoreboard\TeamController');

    // games
    Route::resource('games', 'Admin\Scoreboard\GameController');
    Route::get('gameend', 'Admin\Scoreboard\GameController@gameend')->name('gameend');


    // timer
    Route::resource('timers', 'Admin\Scoreboard\TimerController');

    // scoreboards
    Route::resource('scoreboards', 'Admin\Scoreboard\ScoreboardController');

    // score controller
    Route::resource('score', 'Admin\Score\ScoreController');
    Route::post('/scorecontrollerstart', 'Admin\Score\ScoreController@btnstart')->name('scorecontrollerstart');
    Route::post('/scorecontrollerstop', 'Admin\Score\ScoreController@btnstop')->name('scorecontrollerstop');
    Route::post('/scorecontrollerpause', 'Admin\Score\ScoreController@btnpause')->name('scorecontrollerpause');
    Route::post('/scorecontrollerresume', 'Admin\Score\ScoreController@btnresume')->name('scorecontrollerresume');
    Route::post('/scorenavigate', 'Admin\Score\ScoreController@scorenavigate')->name('scorenavigate');
});


Route::get('publicscore', 'PublicScoreController@index')->name('publicscore');
Route::get('publicscore_new', function () {

    return view('testing');
});

Route::get('myevent', function () {
    event(new Event('Hellooo chamara'));

    return "Done";
});
// Route::get('publicscore', 'PublicScoreController@index')->name('publicscore');
