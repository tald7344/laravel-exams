<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExamController;

/*
  * Namespace has default path (App/Http/Controllers) so any new namespace defined will add to
    default path and the new path will be as : (App/Http/Controllers/Admin)
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    // define the guard from 'config/auth.php' to be admin not web
    Config::set('auth.defines', 'admin');

    // group route if the user is loggedIn
    Route::group(['middleware' => 'adminGuest:admins'], function () {
        Route::get('login', 'AdminAuth@login');
        Route::post('login', 'AdminAuth@doLogin');
        Route::get('forgot/password', 'AdminAuth@forgot_password');
        Route::post('forgot/password', 'AdminAuth@forgot_password_post');
        Route::get('reset/password/{token}', 'AdminAuth@reset_password');
        Route::post('reset/password/{token}', 'AdminAuth@change_password');
    });

    // Check for middleware admin and deffined the guard as :admin | group Route If User Not Logged In
    Route::group(['middleware' => 'admin:admins'], function () {
        Route::get('/', 'DashboardController@index');
        Route::any('logout', 'AdminAuth@logout');

        // Calendar
        Route::get('calendar-event', 'CalendarController@index');
        Route::post('calendar-crud-ajax', 'CalendarController@calendarEvents');
        Route::post('calendar-delete-ajax', 'CalendarController@clearCalendarEvents');

        Route::group(['prefix' => 'to-do'], function () {
            Route::get('/', 'ToDoController@index');
            Route::get('/show', 'ToDoController@show');
            Route::post('/paginate', 'ToDoController@paginateList');
            Route::post('/add-edit', 'ToDoController@addOrEditItem');
            Route::patch('/add-edit', 'ToDoController@addOrEditItem');
            Route::post('/render-details', 'ToDoController@renderItemDetails');
            Route::patch('/checked', 'ToDoController@checkToDoItem');
            Route::delete('/delete', 'ToDoController@deleteToDoItem');
            Route::delete('/show', 'ToDoController@deleteToDoItem');
        });

        // Admin
        Route::resource('admin', 'AdminController');
        Route::delete('admin/destroy/all', 'AdminController@destroyAll');

        // Student
        Route::resource('student', 'StudentController');
        Route::delete('student/destroy/all', 'StudentController@destroyAll');

        // Exam
        Route::resource('exam', 'ExamController');
        Route::delete('exam/destroy/all', 'ExamController@destroyAll');

        // Question
        Route::resource('question', 'QuestionController');

        // Answer
        Route::resource('answer', 'AnswerController');

    });

    Route::get('lang/{lang}', function ($lang) {
        session()->has('lang') ? session()->forget('lang') : '';
        $lang == 'ar' ? session()->put('lang', 'ar') : session()->put('lang', 'en');
        return back();
    });

});
