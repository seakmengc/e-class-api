<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api'
], function () {
    Route::get('users/{user}/exams/{exam}/{questionId}', 'GetStudentUploadedFileInExam')->name('api.files.exams.show');

    Route::get('users/{user}/portrait', 'GetPortrait')->name('api.files.portraits.show');
});
