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

Route::any('/prueba', 'HomeController@GetAlbumsWithPictures');
Route::any('/test', 'HomeController@Test');

Route::any('/', 'PublicController@ViewIndex');

Route::any('/norbertosevilla', 'PublicController@ViewNorbertoSevilla');
Route::any('/album/{Id_Album}', 'PublicController@ViewAlbum');

Route::any('/sobrenorberto', 'PublicController@ViewBiografia');

Route::get('jcrop', function () {
    return view('Jcrop');
});

Route::any('/crop', 'HomeController@CropPicture');

Route::any('/pictures', 'HomeController@ViewPicturesAdmin');

Route::any('/uploadpicture', 'HomeController@UploadPicture');

Route::any('/albums', 'HomeController@ViewAlbumsAdmin');

Route::any('/createalbum', 'HomeController@CreateAlbum');

Route::auth();

Route::get('/home', 'HomeController@index');
