<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/dashboard', 'PostController@index');
Route::get('/', 'PostController@index')->name('home');
Route::get('/songs', 'PostController@songs')->name('songs');
Route::get('/drawings', 'PostController@drawings')->name('drawings');
Route::get('/sports', 'PostController@sport')->name('sports');
Route::get('/about', 'PostController@about')->name('about');
Route::get('/contact', 'PostController@contact')->name('contact');
Route::get('/article/{id}', 'PostController@singleArticle')->name('singleArticle');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(['prefix' => 'articles', 'middleware' => 'admin'], function () {
        Route::get('/', 'ArticleController@index')->name('articleIndex');
        Route::post('/', 'ArticleController@store')->name('articleStore');
        Route::put('/{id}', 'ArticleController@update')->name('articleUpdate');
        Route::get('/create', 'ArticleController@create')->name('articleCreate');
        Route::get('/{id}/edit', 'ArticleController@edit')->name('articleEdit');;
        Route::post('/delete-article/{id}', 'ArticleController@deleteArticle')->name('deleteArticle');
        Route::post('/delete-image/{id}', 'ArticleController@deleteArticleImage')->name('deleteArticleFile');
    });

    Route::group(['prefix' => 'personages', 'middleware' => 'admin'], function () {
        Route::get('/', 'PersonageController@index')->name('personageIndex');
        Route::post('/', 'PersonageController@store')->name('personageStore');
        Route::put('/{id}', 'PersonageController@update')->name('personageUpdate');
        Route::get('/create', 'PersonageController@create')->name('personageCreate');
        Route::get('/{id}/edit', 'PersonageController@edit')->name('personageEdit');;
        Route::post('/delete-personage/{id}', 'PersonageController@deletePersonage')->name('deletePersonage');
        Route::post('/delete-personage-image/{id}', 'PersonageController@deletePersonageImageFile')->name('deletePersonageImageFile');
    });

    Route::resource('/users', 'UserController');
    Route::get('/my-account', 'UserController@myAccount')->name('myAccount');
    Route::post('/account-update', 'UserController@accountUpdate')->name('myAccountUpdate');
});
