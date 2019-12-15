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

Route::get('/', 'WebController@queryGroups');
Route::post('/requestjoin', 'WebController@requestJoin');
Route::post('/removerequestjoin', 'WebController@removeRequestJoin');

Route::get('/creategroup', 'WebController@createGroup');

Route::get('/mygroups', 'WebController@myGroups');
Route::post('/mygroups/delete', 'WebController@deleteGroup');
Route::post('/mygroups/leave', 'WebController@leaveGroup');

Route::get('/login', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
