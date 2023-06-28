<?php

use App\Http\Controllers\CookiesController;
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
Route::get('/shops', 'PostController@shop')->name('shops');
Route::get('/article/{id}', 'PostController@singleArticle')->name('singleArticle');
Route::get('/download-image/{id}', 'PostController@downloadDrawingImage')->name('downloadDrawingImage');

Route::get('/faq', function () {
    return view('faq.faq');
});
Route::get('/terms', function () {
    return view('faq.terms');
});

Route::get('/privacy', function () {
    return view('faq.privacy');
});

Route::middleware('throttle:only_three_requests')->group(function () {
    Route::post('/add-comment/{id}', 'CommentController@addComment')->name('addComment');
    Route::post('/contactMessage', 'PostController@contactMessage')->name('contactMessage');
});


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
        Route::post('/delete-personage-image/{id}',
            'PersonageController@deletePersonageImageFile')->name('deletePersonageImageFile');
    });


    Route::group(['prefix' => 'messages', 'middleware' => 'admin'], function () {
        Route::get('/', 'ContactMessagesController@index')->name('contactMessagesIndex');
        Route::get('/show/{id}', 'ContactMessagesController@show')->name('contactMessagesShow');
        Route::post('/delete-message/{id}',
            'ContactMessagesController@deleteContactMessage')->name('deleteContactMessage');
    });

    Route::group(['prefix' => 'comments', 'middleware' => 'admin'], function () {
        Route::get('/', 'CommentController@index')->name('commentIndex');
        Route::post('/approve-comment/{id}', 'CommentController@approveComment')->name('approveComment');
        Route::post('/delete-comment/{id}', 'CommentController@deleteCommentMessage')->name('deleteCommentMessage');
    });


    Route::group(['prefix' => 'shop', 'middleware' => 'admin'], function () {
        Route::get('/', 'ShopController@index')->name('shopIndex');
        Route::post('/', 'ShopController@store')->name('shopStore');
        Route::put('/{id}', 'ShopController@update')->name('shopUpdate');
        Route::get('/create', 'ShopController@create')->name('shopCreate');
        Route::get('/{id}/edit', 'ShopController@edit')->name('shopEdit');;
        Route::post('/delete-article/{id}', 'ShopController@deleteShopArticle')->name('deleteShopArticle');
        Route::post('/delete-image/{id}', 'ShopController@deleteShopArticleImage')->name('deleteShopArticleImage');
    });

    Route::resource('/users', 'UserController');
    Route::get('/my-account', 'UserController@myAccount')->name('myAccount');
    Route::post('/account-update', 'UserController@accountUpdate')->name('myAccountUpdate');

    Route::group(['prefix' => 'social-network', 'middleware' => 'admin'], function () {
        Route::get('/', 'SocialNetworkController@index')->name('SocialNetworkIndex');
        Route::post('/', 'SocialNetworkController@store')->name('SocialNetworkStore');
        Route::put('/{id}', 'SocialNetworkController@update')->name('SocialNetworkUpdate');
        Route::get('/create', 'SocialNetworkController@create')->name('SocialNetworkCreate');
        Route::get('/{id}/edit', 'SocialNetworkController@edit')->name('SocialNetworkEdit');;
        Route::post('/delete-social-network/{id}',
            'SocialNetworkController@deleteSocialNetwork')->name('deleteSocialNetwork');
    });
});


Route::get('/set-cookie', [CookiesController::class, 'setCookie']);
Route::get('/get-cookie', [CookiesController::class, 'getCookie']);
Route::get('/delete-cookie', [CookiesController::class, 'deleteCookie']);
