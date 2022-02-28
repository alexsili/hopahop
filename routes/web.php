<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', 'PostController@index')->name('home');
Route::get('/songs', 'PostController@songs')->name('songs');
Route::get('/drawings', 'PostController@drawings')->name('drawings');
Route::get('/about', 'PostController@about')->name('about');
Route::get('/contact', 'PostController@contact')->name('contact');


Route::middleware(['auth', 'verified'])->group(function () {
//    Route::group(['prefix' => 'articles', 'middleware' => 'admin'], function () {
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', 'ArticleController@index')->name('articleIndex');
        Route::post('/', 'ArticleController@store')->name('articleStore');
        Route::put('/{id}', 'ArticleController@update')->name('articleUpdate');
        Route::get('/create', 'ArticleController@create')->name('articleCreate');
        Route::get('/{id}/edit', 'ArticleController@edit')->name('articleEdit');;
        Route::post('/delete-image/{id}', 'ArticleController@deleteArticleImage')->name('deleteArticleFile');
    });

    Route::resource('/users', 'UserController');
    Route::get('/my-account', 'UserController@myAccount')->name('myAccount');
    Route::post('/account-update', 'UserController@accountUpdate')->name('myAccountUpdate');
});
