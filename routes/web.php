<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\DashboardController@homePage')->name('dashboard.homePage');

Route::get('/register', 'App\Http\Controllers\RegistrationController@registrationPage')->name('register.registrationPage');
Route::post('/register', 'App\Http\Controllers\RegistrationController@create')->name('register.create');
Route::post('/register/upload-logo', 'App\Http\Controllers\RegistrationController@teamLogoUpload')->name('register.teamLogoUpload');
Route::get('/login', 'App\Http\Controllers\LoginController@loginPage')->name('login.login');
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login.auth');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], static function () {
    Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');
    Route::get('/teams', 'App\Http\Controllers\DashboardController@teamPage')->name('dashboard.teampage');
    Route::get('/information', 'App\Http\Controllers\DashboardController@teamInformationPage')->name('dashboard.teamInformationPage');
    Route::post('/update', 'App\Http\Controllers\DashboardController@updateUser')->name('dashboard.updateuser');
    Route::post('/create/schedule', 'App\Http\Controllers\DashboardController@createTeamSchedule')->name('dashboard.createTeamSchedule');
    Route::post('/create/game-schedule', 'App\Http\Controllers\DashboardController@sendBattleRequest')->name('dashboard.sendBattleRequest');
    Route::get('/notifications', 'App\Http\Controllers\NotificationsController@index')->name('dashboard.notifications');
    Route::get('/invitation/accept/{id}', 'App\Http\Controllers\NotificationsController@acceptInvitation')->name('dashboard.acceptInvitation');
    Route::get('/tournament', 'App\Http\Controllers\TournamentController@index')->name('tournament.index');
});
Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->name('login.logout');
