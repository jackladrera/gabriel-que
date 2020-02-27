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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::resource('songs', 'SongController');
Route::resource('publishers', 'PublisherController');
Route::resource('artists', 'ArtistController');
Route::resource('shows', 'ShowController');
Route::resource('projects', 'ProjectController');