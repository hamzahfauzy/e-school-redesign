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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
	Route::post('login', 'Api\AuthController@login');
	Route::post('register', 'Api\AuthController@register');
	Route::group(['middleware' => 'auth:api'], function(){
		Route::post('getUser', 'Api\AuthController@getUser');
		Route::post('logout', 'Api\AuthController@logout');
	});

    Route::get('school/get/{school}/majors','Api\HomeController@findMajors');
    Route::get('school/get/{school}/majors/{major}/classrooms','Api\HomeController@findClassrooms');
    Route::get('school/{keyword}','Api\HomeController@findSchool');
    Route::post('finish-registration','Api\HomeController@finishRegistration');
    Route::post('get-posts','Api\HomeController@getPosts');
    Route::post('save-post','Api\HomeController@savePost');
    Route::post('save-comment','Api\HomeController@saveComment');

	Route::prefix('user')->group(function(){
        Route::get('', 'Api\UserController@index');
        Route::post('create','Api\UserController@register');
        Route::get('{ID}','Api\UserController@single');
        Route::post('update','Api\UserController@update');
        Route::delete('delete','Api\UserController@delete');
        Route::post('addRole','Api\UserController@addRole');
        Route::delete('deleteRole','Api\UserController@deleteRole');
    });

    Route::prefix('role')->group(function(){
        Route::get('', 'Api\RoleController@index');
        Route::get('{ID}','Api\RoleController@single');
        Route::get('{ID}/menu','Api\RoleController@menu');
        Route::get('{ID}/menu/find/{menu}','Api\RoleController@findMenu');
        Route::post('create','Api\RoleController@create');
        Route::post('update','Api\RoleController@update');
        Route::delete('delete','Api\RoleController@delete');
        Route::post('{ID}/menu/create','Api\RoleController@menuInsert');
        Route::post('{ID}/menu/update','Api\RoleController@menuUpdate');
        Route::delete('{ID}/menu/delete','Api\RoleController@deleteMenu');
    });

    Route::prefix('cloud')->group(function(){
        Route::get('index','Api\CloudSettingController@index');
        Route::post('update','Api\CloudSettingController@update');
    });

    // InformationSystem
    Route::prefix('student')->group(function(){
        Route::get('','Api\InformationSystem\StudentController@index');
        Route::get('{ID}','Api\InformationSystem\StudentController@single');
        Route::post('create','Api\InformationSystem\StudentController@create');
        Route::post('update','Api\InformationSystem\StudentController@update');
        Route::delete('delete','Api\InformationSystem\StudentController@delete');
    });

    Route::prefix('study')->group(function(){
        Route::get('','Api\InformationSystem\StudyController@index');
        Route::get('{ID}','Api\InformationSystem\StudyController@single');
        Route::post('create','Api\InformationSystem\StudyController@create');
        Route::post('update','Api\InformationSystem\StudyController@update');
        Route::delete('delete','Api\InformationSystem\StudyController@delete');
    });

    Route::prefix('major')->group(function(){
        Route::get('','Api\InformationSystem\MajorController@index');
        Route::get('{ID}','Api\InformationSystem\MajorController@single');
        Route::post('create','Api\InformationSystem\MajorController@create');
        Route::post('update','Api\InformationSystem\MajorController@update');
        Route::delete('delete','Api\InformationSystem\MajorController@delete');
    });

    Route::prefix('employee')->group(function(){
        Route::get('','Api\InformationSystem\EmployeeController@index');
        Route::get('{ID}','Api\InformationSystem\EmployeeController@single');
        Route::post('create','Api\InformationSystem\EmployeeController@create');
        Route::post('update','Api\InformationSystem\EmployeeController@update');
        Route::delete('delete','Api\InformationSystem\EmployeeController@delete');

        Route::post('addStudy','Api\InformationSystem\EmployeeController@addStudy');
        Route::delete('deleteStudy','Api\InformationSystem\EmployeeController@deleteStudy');
    });

    Route::prefix('schedule')->group(function(){
        Route::get('','Api\InformationSystem\ScheduleController@index');
        Route::get('{ID}','Api\InformationSystem\ScheduleController@single');
        Route::post('create','Api\InformationSystem\ScheduleController@create');
        Route::post('update','Api\InformationSystem\ScheduleController@update');
        Route::delete('delete','Api\InformationSystem\ScheduleController@delete');
    });

    Route::prefix('class_room')->group(function(){
        Route::get('','Api\InformationSystem\ClassroomController@index');
        Route::get('{ID}','Api\InformationSystem\ClassroomController@single');
        Route::post('create','Api\InformationSystem\ClassroomController@create');
        Route::post('update','Api\InformationSystem\ClassroomController@update');
        Route::delete('delete','Api\InformationSystem\ClassroomController@delete');

        Route::post('addStudent','Api\InformationSystem\ClassroomController@addStudent');
        Route::delete('deleteStudent','Api\InformationSystem\ClassroomController@deleteStudent');
    });

    // LockerStorage
    Route::prefix('folder')->group(function(){
        Route::post('/','Api\LockerStorage\FolderController@index');
        Route::post('create','Api\LockerStorage\FolderController@create');
        Route::delete('delete','Api\LockerStorage\FolderController@delete');
    });

    Route::prefix('files')->group(function(){
        Route::post('all','Api\LockerStorage\FileController@all');
        Route::get('{id}','Api\LockerStorage\FileController@single');
        Route::post('index/{folder}','Api\LockerStorage\FileController@index');
        Route::post('upload','Api\LockerStorage\FileController@upload');
        Route::post('share','Api\LockerStorage\FileController@share');
        Route::delete('delete','Api\LockerStorage\FileController@delete');
    });

    Route::prefix('share')->group(function(){
        Route::post('','Api\LockerStorage\ShareFileController@index');
    });

    // Elearning
    Route::prefix('announcement')->group(function(){
        Route::get('{teacher_id}','Api\Elearning\AnnouncementController@index');
        Route::get('get/{ID}','Api\Elearning\AnnouncementController@single');
        Route::get('get-by-classroom/{classroom}','Api\Elearning\AnnouncementController@getByClassroom');
        Route::post('create','Api\Elearning\AnnouncementController@create');
        Route::post('update','Api\Elearning\AnnouncementController@update');
        Route::delete('delete','Api\Elearning\AnnouncementController@delete');
    });

    Route::prefix('assignment-answer')->group(function(){
        Route::get('{student_id}','Api\Elearning\AssignmentAnswerController@get');
        Route::post('create','Api\Elearning\AssignmentAnswerController@create');
    });

    Route::prefix('assignment')->group(function(){
        Route::get('{teacher_id}','Api\Elearning\AssignmentController@index');
        Route::get('get/{ID}','Api\Elearning\AssignmentController@single');
        Route::get('get-answers/{assignment}','Api\Elearning\AssignmentController@get');
        Route::post('create','Api\Elearning\AssignmentController@create');
        Route::post('update','Api\Elearning\AssignmentController@update');
        Route::delete('delete','Api\Elearning\AssignmentController@delete');
    });

    Route::prefix('question')->group(function(){
        Route::get('{teacher_id}','Api\Elearning\QuestionController@index');
        Route::get('get/{ID}','Api\Elearning\QuestionController@single');
        Route::post('set-correct-answer','Api\Elearning\QuestionController@setCorrectAnswer');
        Route::post('create','Api\Elearning\QuestionController@create');
        Route::post('update','Api\Elearning\QuestionController@update');
        Route::delete('delete','Api\Elearning\QuestionController@delete');
    });

    Route::prefix('exam')->group(function(){
        Route::get('{teacher_id}','Api\Elearning\ExamController@index');
        Route::get('get/{exam}','Api\Elearning\ExamController@single');
        Route::get('get-with-students/{ID}','Api\Elearning\ExamController@singleWithStudents');
        Route::get('get/{exam}/answers/{student}','Api\Elearning\ExamController@answers');
        Route::get('get-status/{ID}/answers/{student_id}','Api\Elearning\ExamController@getStatus');
        Route::post('get-student-answer','Api\Elearning\ExamController@getStudentAnswer');
        Route::post('get-student-total-score','Api\Elearning\ExamController@getStudentTotalScore');
        Route::post('set-student-score','Api\Elearning\ExamController@setStudentScore');
        Route::post('finish','Api\Elearning\ExamController@setStatus');
        Route::post('create','Api\Elearning\ExamController@create');
        Route::post('update','Api\Elearning\ExamController@update');
        Route::delete('delete','Api\Elearning\ExamController@delete');
    });

    Route::prefix('exam_item')->group(function(){
        Route::get('{exam_id}','Api\Elearning\ExamItemController@index');
        Route::get('get/{ID}','Api\Elearning\ExamItemController@single');
        Route::post('answer','Api\Elearning\ExamItemController@answer');
        Route::post('create','Api\Elearning\ExamItemController@create');
        Route::post('update','Api\Elearning\ExamItemController@update');
        Route::delete('delete','Api\Elearning\ExamItemController@delete');
    });

    Route::prefix('answer')->group(function(){
        Route::get('{question_id}','Api\Elearning\AnswerController@index');
        Route::get('get/{ID}','Api\Elearning\AnswerController@single');
        Route::post('create','Api\Elearning\AnswerController@create');
        Route::post('update','Api\Elearning\AnswerController@update');
        Route::delete('delete','Api\Elearning\AnswerController@delete');
    });

    Route::prefix('virtual_classroom')->group(function(){
        Route::get('{teacher_id}','Api\Elearning\VirtualClassroomController@index');
        Route::get('get/{ID}','Api\Elearning\VirtualClassroomController@single');
        Route::post('create','Api\Elearning\VirtualClassroomController@create');
        Route::post('update','Api\Elearning\VirtualClassroomController@update');
        Route::delete('delete','Api\Elearning\VirtualClassroomController@delete');
    });
});