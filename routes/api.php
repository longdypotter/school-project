<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'namespace' => 'Api'], function(){
    Route::get('address/{code?}', 'AddressController@get')->name('address.get');
 });

 Route::resource('document','Api\DocumentController');
//  Route::get('student/download/{id}','Api\StudentController@download')->name('student.download');
 Route::delete('document/deletefile/{id}','Api\DocumentController@deletefile');

 //class
//Route::post('document/showclass/{id}','Api\DocumentController@showclass')->name('document.showclass');


//Route::resource('document','Api\Documentontroller');
//  //  Route::get('student/download/{id}','Api\StudentController@download')->name('student.download');
//   Route::delete('student/deletefile/{id}','Api\StudentController@deletefile');
 Route::resource('testresult','Api\ResultController');
 Route::delete('testresult/deletefile/{id}','Api\ResultController@deletefile');

 Route::resource('criminal','Api\CriminalController');
 Route::delete('criminal/deletefile/{id}','Api\CriminalController@deletefile');

 Route::resource('health','Api\HealthController');
 Route::delete('health/deletefile/{id}','Api\HealthController@deletefile');

 Route::resource('graduatestudentfollowup','Api\StudentFollowupController');
 Route::delete('graduatestudentfollowup/deletefile/{id}','Api\StudentFollowupController@deletefile');

 Route::resource('followup','Api\FollowupController');
 Route::delete('followup/deletefile/{id}','Api\FollowupController@deletefile');

 //selectdropdown
 Route::get('studentexam/section','Api\StudentExamController@sectiontosubject')->name('get.section');
 Route::get('studentexam/nametoexamdate','Api\StudentExamController@nametoexamdate')->name('get.nametoexamdate');
 Route::get('studentexam/examdatetoclass','Api\StudentExamController@examdatetoclass')->name('get.examdatetoclass'); 
 Route::resource('studentexam','Api\StudentExamController');   

 Route::group([ 'namespace' => 'Api'], function(){
    Route::get('student', 'StudentController@index')->name('api.student');
    Route::get('teacher', 'TeacherController@index')->name('api.teacher');

});





 