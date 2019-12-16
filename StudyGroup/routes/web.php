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

//Anything to do with the index view and finding a group
Route::get('/', 'WebController@queryGroups');
Route::post('/requestjoin', 'WebController@requestJoin');
Route::post('/removerequestjoin', 'WebController@removeRequestJoin');

//Creating a group
Route::get('/creategroup', 'WebController@createGroup');

//Anything to do with the mygroups page (including APIs)
Route::get('/mygroups', 'WebController@myGroups');
Route::get('/mygroups/users', 'WebController@getUsersFromGroup');
Route::post('/mygroups/removeuserfromgroup', 'WebController@removeUserFromGroup');
Route::post('/mygroups/acceptuserintogroup', 'WebController@acceptUserIntoGroup');
Route::post('/mygroups/delete', 'WebController@deleteGroup');
Route::post('/mygroups/leave', 'WebController@leaveGroup');

//Login and registration callbacks from Google SSO, and logout directive
Route::get('/login', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/logout', 'Auth\LoginController@logout');

//Profile page
Route::get('/profile', function() {
	return view('profile');
});