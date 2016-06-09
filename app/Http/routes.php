<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/prueba', 'HomeController@GetAlbumsWithPictures');

Route::get('/', function () {
    return view('Index');
});

Route::get('norbertosevilla', function () {
    return view('NorbertoSevilla');
});

Route::get('sobrenorberto', function () {
    return view('Biografia');
});

Route::get('jcrop', function () {
    return view('Jcrop');
});

Route::any('crop', function () {

});

Route::any('/pictures', 'HomeController@ViewPicturesAdmin');

Route::any('/albums', 'HomeController@ViewAlbumsAdmin');

Route::any('/createalbum', 'HomeController@CreateAlbum');

Route::auth();

Route::get('/home', 'HomeController@index');
