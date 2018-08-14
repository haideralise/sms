<?php

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


Route::prefix('v1')->group(function () {

    Route::post('register', 'RegisterController@web');

    Route::post('login', 'LoginController@web');

    Route::group(['middleware' => ['jwt.auth']], function () {

        Route::get('campuses/{campus}/lookup-data', 'CampusController@lookupData');

        Route::get('campuses/{campus}/students', 'StudentController@index');

        Route::post('campuses/{campus}/students', 'StudentController@store');

        Route::get('campuses/{campus}/students/{student}', 'StudentController@show');

        Route::put('campuses/{campus}/students/{student}', 'StudentController@update');

        Route::delete('campuses/{campus}/students/{student}', 'StudentController@delete');

        Route::get('/campuses/{campus}/guardian-suggestions', 'GuardianController@search');


        Route::get('campuses/{campus}/teachers', 'TeacherController@index');

        Route::post('campuses/{campus}/teachers', 'TeacherController@store');

        Route::get('campuses/{campus}/teachers/{teacher}', 'TeacherController@show');

        Route::put('campuses/{campus}/teachers/{teacher}', 'TeacherController@update');

        Route::delete('campuses/{campus}/teachers/{teacher}', 'TeacherController@delete');


        Route::get('campuses/{campus}/grades', 'GradeController@index');

        Route::post('campuses/{campus}/grades', 'GradeController@store');

        Route::put('campuses/{campus}/grades/{grade}', 'GradeController@update');

        Route::delete('campuses/{campus}/grades/{grade}', 'GradeController@delete');


        Route::get('grades/{grade}/sections', 'SectionController@index');

        Route::post('grades/{grade}/sections', 'SectionController@store');

        Route::put('grades/{grade}/sections/{section}', 'SectionController@update');

        Route::get('grades/{grade}/sections/{section}', 'SectionController@show');

        Route::delete('grades/{grade}/sections/{section}', 'SectionController@delete');

        Route::post('sections/{section}/subjects', 'SectionController@syncSubjects');

        Route::get('sections/{section}/subjects', 'SubjectController@sectionSubjects');


        Route::get('campuses/{campus}/subjects', 'SubjectController@index');

        Route::post('campuses/{campus}/subjects', 'SubjectController@store');

        Route::put('campuses/{campus}/subjects/{subject}', 'SubjectController@update');

        Route::delete('campuses/{campus}/subjects/{subject}', 'SubjectController@delete');


        Route::get('sections/{section}/student-attendances', 'StudentAttendanceController@index');

        Route::post('sections/{section}/student-attendances', 'StudentAttendanceController@store');

        Route::get('sections/{section}/student-attendance-overview', 'StudentAttendanceController@overview');

        Route::put('sections/{section}/student-attendances/{attendance}', 'StudentAttendanceController@update');


        Route::get('/campuses/{campus}/teacher-attendances', 'TeacherAttendanceController@index');

        Route::post('/campuses/{campus}/teacher-attendances', 'TeacherAttendanceController@store');

        Route::get('/campuses/{campus}/teacher-attendance-overview', 'TeacherAttendanceController@overview');

        Route::put('/campuses/{campus}/teacher-attendances/{attendance}', 'TeacherAttendanceController@update');
    });
});



