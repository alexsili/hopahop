<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);


//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'DashboardController@index')->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => 'submissions', 'middleware' => 'author'], function () {
        Route::get('/{id}/review', 'SubmissionController@getReview');
        Route::post('/add-revision/{id}', 'SubmissionController@addRevision')->name('addRevision');;
        Route::get('/messages/{id}', 'SubmissionController@messages')->name('messages');;
        Route::get('/', 'SubmissionController@index')->name('submissionIndex');
        Route::post('/', 'SubmissionController@store')->name('submissionStore');
        Route::put('/{id}', 'SubmissionController@update')->name('submissionUpdate');
        Route::get('/create', 'SubmissionController@create')->name('submissionCreate');
        Route::get('/{id}', 'SubmissionController@show')->name('submissionShow');
        Route::get('/{id}/edit', 'SubmissionController@edit')->name('submissionEdit');
        Route::post('/{id}/edit', 'SubmissionController@edit')->name('submissionEdit');

        Route::post('/delete-author/{id}', 'SubmissionController@deleteAuthor')->name('deleteAuthor');
        Route::post('/delete-submission-file/{id}', 'SubmissionController@deleteSubmissionFile')->name('deleteSubmissionFile');
        Route::post('/delete-cover-letter/{id}', 'SubmissionController@deleteCoverLetter')->name('deleteCoverLetter');
        Route::post('/delete-supplementary-files/{id}', 'SubmissionController@deleteSupplementaryFiles')->name('deleteSupplementaryFiles');
    });

    Route::group(['prefix' => 'reviewer', 'middleware' => 'reviewer'], function () {
        Route::get('/', 'ReviewerController@index')->name('reviewerIndex');
        Route::get('/active', 'ReviewerController@active')->name('reviewerActive');
        Route::get('/summary/{id}', 'ReviewerController@getSummary')->name('reviewerSummary');
        Route::get('/review/{id}', 'ReviewerController@getReview')->name('reviewerReview');
        Route::get('/show/{id}', 'ReviewerController@show')->name('reviewerShow');
        Route::get('/archive', 'ReviewerController@archive')->name('reviewerArchive');
        Route::post('/respose/{id}', 'ReviewerController@postResponse')->name('reviewerResponse');
        Route::post('/post-review-new/{id}', 'ReviewerController@postReviewNew')->name('postReviewNew');
        Route::post('/post-review-active/{id}', 'ReviewerController@postReviewActive')->name('postReviewActive');
    });

    Route::group(['prefix' => 'editor', 'middleware' => 'editor'], function () {
        Route::get('/', 'EditorController@index')->name('editorIndex');
        Route::get('/author', 'EditorController@author')->name('editorAuthor');
        Route::get('/assigned', 'EditorController@assigned')->name('editorAssigned');
        Route::get('/inreview', 'EditorController@inreview')->name('editorInReview');
        Route::get('/inediting', 'EditorController@inediting')->name('editorInEditing');
        Route::get('/show/{id}', 'EditorController@show')->name('editorShow');
        Route::get('/select-reviewers/{id}', 'EditorController@selectReviewers')->name('editorSelectReviewers');
        Route::post('/select-reviewers/{id}', 'EditorController@postSelectedReviewers')->name('postSelectedReviewers');
        Route::get('/confirm-selected-reviewers/{submissionId}/{reviewerIds?}', 'EditorController@confirmSelectedReviewers')->name('confirmSelectedReviewers');
        Route::post('/invite-reviewers/{id}', 'EditorController@inviteReviewers')->name('editorInviteReviewers');
        Route::post('/confirm-reviewers/{id}', 'EditorController@confirmReviewersData')->name('confirmReviewersData');
        Route::get('/assign/{id}', 'EditorController@assign')->name('editorAssign');
        Route::post('/invite-reviewers/{id}/search', 'EditorController@search');

    });

    Route::post('/archives/search', 'ArchiveController@search');
    Route::resource('/archives', 'ArchiveController');

    Route::resource('/users', 'UserController');

    Route::get('/my-account', 'UserController@myAccount')->name('myAccount');
    Route::post('/account-update', 'UserController@accountUpdate')->name('myAccountUpdate');
});
