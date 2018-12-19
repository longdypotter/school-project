<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
   
    CRUD::resource('student', 'StudentCrudController');
  
    Route::get('file/delete/{id}','FileCrudController@deletefile')->name('file.destroy');
    CRUD::resource('class', 'ClassesCrudController');
    CRUD::resource('downloadcenter', 'DownloadCenterCrudController');
    CRUD::resource('documenttype', 'DocumentTypeCrudController');
    CRUD::resource('filetype', 'FileTypeCrudController');
    CRUD::resource('section', 'SectionCrudController');
    CRUD::resource('session', 'SessionCrudController');
    CRUD::resource('subject', 'SubjectCrudController');
    CRUD::resource('teacher', 'TeacherCrudController');
  
    CRUD::resource('assignsubject','AssignSubjectCrudController');
    CRUD::resource('studentsession','StudentsessionCrudController');

    CRUD::resource('followuptype','FollowupTypeCrudController');
    CRUD::resource('followup','FollowupCrudController');
    
    CRUD::resource('studentfollowuptype','StudentFollowupTypeCrudController');
    CRUD::resource('studentfollowuptype','StudentFollowupTypeCrudController');

    CRUD::resource('healthtype','HealthTypeCrudController');
    CRUD::resource('graduatestudent','GraduateStudentCrudController');
    CRUD::resource('my-account','MyAccountCrudController');

    CRUD::resource('attachment','AttachmentCrudController');
    CRUD::resource('attachmenttype','AttachmentTypeCrudController');
    

    //attendent
    CRUD::resource('attendentstudent','AttendentStudentCrudController');
    Route::post('attendentstudent/store','SearchAttendentStudentCrudController@createattendentstudent')->name('attendentstudent.createattendentstudent');
    CRUD::resource('searchattendentstudent','SearchAttendentStudentCrudController');
    CRUD::resource('attendentteacher','AttendentTeacherCrudController');

    //exam
    Route::post('studentexam/updatestudentexam/{id}','StudentExamCrudController@updatestudentexam')->name('studentexam.updatestudentexam');
    
    Route::get('studentexam/showstudentexam/{id}','StudentExamCrudController@showstudentexam')->name('studentexam.showstudentexam');
    Route::get('studentexam/deletestudentexam/{id}','StudentExamCrudController@deletestudentexam')->name('studentexam.deletestudentexam');
  
    CRUD::resource('studentexam','StudentExamCrudController');
    Route::get('exam/inputmarkstudentexam/{id}','ExamCrudController@inputmarkstudentexam')->name('exam.inputmarkstudentexam');
   
    CRUD::resource('exam','ExamCrudController');
  

    //report
    CRUD::resource('report/student-info', 'ReportStudentCrudController');
    CRUD::resource('report/teacher-info','ReportTeacherCrudController');

    //endreport

    // Route::post('attendentstudent/form','AttendentStudentCrudController@form')->name('attendentstudent.form');

    Route::get('viewattendentstudent/{attendentdate}','AttendentStudentCrudController@viewattendentstudent')->name('viewattendentstudent.show');
    Route::get('deleteattendentstudent/{attendentdate}','AttendentStudentCrudController@deleteattendentstudent')->name('deleteattendentstudent.delete');
   
    Route::get('viewattendentteacher','AttendentTeacherCrudController@view')->name('attendentteacher.view');
    Route::get('formstudentexam','StudentExamCrudController@formstudentexam')->name('studentexam.createformexam');

}); // this should be the absolute last line of this file
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers',
], function () { // custom admin routes
    Route::get('download-file/{fileName}', 'DownloadController@index')->name('download.index');
    Route::get('download-center/{id}', 'DownloadController@downloadCenter')->name('download.downloadCenter');
    Route::get('download-file/document/{fileName}', 'DownloadController@downloaddoc')->name('download.doc');
    Route::get('download-file/result/{fileName}', 'DownloadController@downloadresult')->name('download.result');
    Route::get('download-file/criminal/{fileName}', 'DownloadController@downloadcriminal')->name('download.criminal');
    Route::get('download-file/health/{fileName}', 'DownloadController@downloadhealth')->name('download.health');
    Route::get('download-file/studentfollowup/{fileName}', 'DownloadController@downloadstudentfollowup')->name('download.downloadstudentfollowup');
    Route::get('download-file/attachment/{fileName}','DownloadController@downloadattachment')->name('download.attachment');
    Route::get('dashboard','DashBoardController@index');
    Route::get('download-file/followup/{fileName}', 'DownloadController@downloadfollowup')->name('download.downloadfollowup');
});

