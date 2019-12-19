<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect('/home');
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth','checkActive'])->group(function(){
	Route::get('/step/{step}', 'HomeController@step')->name('step');
	Route::middleware('checkSchool')->group(function(){
		Route::get('/home', 'HomeController@index')->name('home');
		Route::get('/chats','HomeController@chats')->name('chats.index');
		// Route::get('/locker-storage','HomeController@lockerStorage')->name('locker-storage.index');
		Route::get('/locker-storage',function(){
				return "<h2>Coming soon</h2>";
			})->name('locker-storage.index');

		Route::middleware('role:admin')->prefix('admin')->group(function(){
			Route::prefix('products')->group(function(){
				Route::get('/','ProductController@index')->name('product.index');
				Route::get('create','ProductController@create')->name('product.create');
				Route::get('edit/{id}','ProductController@edit')->name('product.edit');
				Route::post('store','ProductController@store')->name('product.store');
				Route::post('update/{id}','ProductController@update')->name('product.update');
				Route::delete('delete/{id}','ProductController@destroy')->name('product.delete');
			});
			Route::prefix('payments')->group(function(){
				Route::get('/','PaymentController@index')->name('payment.index');
				Route::get('decline/{id}','PaymentController@decline')->name('payment.decline');
				Route::get('accept/{id}','PaymentController@accept')->name('payment.accept');
				Route::get('pending/{id}','PaymentController@pending')->name('payment.pending');
				Route::delete('delete/{id}','PaymentController@destroy')->name('payment.delete');
			});
			Route::prefix('roles')->group(function(){
				Route::get('/','RoleController@index')->name('role.index');
				Route::get('create','RoleController@create')->name('role.create');
				Route::get('edit/{id}','RoleController@edit')->name('role.edit');
				Route::post('store','RoleController@store')->name('role.store');
				Route::post('update/{id}','RoleController@update')->name('role.update');
				Route::delete('delete/{id}','RoleController@destroy')->name('role.delete');
			});
			Route::prefix('menus')->group(function(){
				Route::get('/','MenuController@index')->name('menu.index');
				Route::get('create','MenuController@create')->name('menu.create');
				Route::get('edit/{id}','MenuController@edit')->name('menu.edit');
				Route::post('store','MenuController@store')->name('menu.store');
				Route::post('update/{id}','MenuController@update')->name('menu.update');
				Route::delete('delete/{id}','MenuController@destroy')->name('menu.delete');
			});
			Route::prefix('customers')->group(function(){
				Route::get('/','CustomerController@index')->name('customer.index');
				Route::get('create','CustomerController@create')->name('customer.create');
				Route::get('edit/{id}','CustomerController@edit')->name('customer.edit');
				Route::get('new','CustomerController@new')->name('customer.new');
				Route::post('store','CustomerController@store')->name('customer.store');
				Route::post('nstore','CustomerController@newstore')->name('customer.nstore');
				Route::post('update/{id}','CustomerController@update')->name('customer.update');
				Route::get('disable/{id}','CustomerController@disable')->name('customer.disable');
				Route::get('active/{id}','CustomerController@active')->name('customer.active');
				Route::get('expired/{id}','CustomerController@expired')->name('customer.expired');
				Route::delete('delete/{id}','CustomerController@destroy')->name('customer.delete');
			});
			Route::prefix('users')->group(function(){
				Route::get('/','UserController@index')->name('user.index');
				Route::get('create','UserController@create')->name('user.create');
				Route::get('edit/{id}','UserController@edit')->name('user.edit');
				Route::post('store','UserController@store')->name('user.store');
				Route::post('update/{id}','UserController@update')->name('user.update');
				Route::get('inactive/{id}','UserController@inactive')->name('user.inactive');
				Route::get('active/{id}','UserController@active')->name('user.active');
				Route::delete('delete/{id}','UserController@destroy')->name('user.delete');
			});
		});

		Route::middleware('role:admin_sistem_informasi')->prefix('sistem-informasi')->namespace('Customer')->name('sistem-informasi.')->group(function(){
			Route::get('roles','RoleController@index')->name('roles.index');
			Route::get('students','UserController@students')->name('students.index');
			Route::get('teachers','UserController@teachers')->name('teachers.index');
			Route::prefix('schools')->name('schools.')->group(function(){
				Route::get('/','SchoolController@index')->name('index');
				Route::put('update','SchoolController@update')->name('update');
				Route::post('upload','SchoolController@upload')->name('upload');
			});

			Route::prefix('users')->name('users.')->group(function(){
				Route::get('/','UserController@index')->name('index');
				Route::get('create','UserController@create')->name('create');
				Route::get('edit/{id}','UserController@edit')->name('edit');
				Route::get('add-role/{id}','UserController@addRole')->name('add-role');
				Route::post('store','UserController@store')->name('store');
				Route::post('update/{id}','UserController@update')->name('update');
				Route::post('save-role/{id}','UserController@saveRole')->name('save-role');
				Route::delete('delete-role/{id}','UserController@destroyRole')->name('delete-role');
				Route::delete('delete/{id}','UserController@destroy')->name('delete');
			});

			Route::prefix('studies')->name('studies.')->group(function(){
				Route::get('/','StudyController@index')->name('index');
				Route::get('create','StudyController@create')->name('create');
				Route::get('edit/{id}','StudyController@edit')->name('edit');
				Route::post('store','StudyController@store')->name('store');
				Route::put('update/{id}','StudyController@update')->name('update');
				Route::delete('delete/{id}','StudyController@destroy')->name('delete');
			});

			Route::prefix('majors')->name('majors.')->group(function(){
				Route::get('/','MajorController@index')->name('index');
				Route::get('create','MajorController@create')->name('create');
				Route::get('edit/{id}','MajorController@edit')->name('edit');
				Route::post('store','MajorController@store')->name('store');
				Route::put('update/{id}','MajorController@update')->name('update');
				Route::delete('delete/{id}','MajorController@destroy')->name('delete');
			});

			Route::prefix('classrooms')->name('classrooms.')->group(function(){
				Route::get('/','ClassroomController@index')->name('index');
				Route::get('create','ClassroomController@create')->name('create');
				Route::get('edit/{id}','ClassroomController@edit')->name('edit');
				Route::get('show/{id}','ClassroomController@show')->name('show');
				Route::get('show-studies/{id}','ClassroomController@showStudies')->name('show-studies');
				Route::get('show/{id}/create','ClassroomController@studentCreate')->name('students.create');
				Route::get('show-studies/{id}/create','ClassroomController@studyCreate')->name('studies.create');
				Route::get('show-studies/{id}/edit/{study_id}','ClassroomController@studyEdit')->name('studies.edit');
				Route::post('store-student','ClassroomController@storeStudent')->name('students.store');
				Route::post('store-study','ClassroomController@storeStudy')->name('studies.store');
				Route::post('store','ClassroomController@store')->name('store');
				Route::post('update/{id}','ClassroomController@update')->name('update');
				Route::post('update/{id}/studies/{study_id}','ClassroomController@updateStudy')->name('studies.update');
				Route::delete('delete/{id}','ClassroomController@destroy')->name('delete');
				Route::delete('delete/{id}/student/{user_id}','ClassroomController@destroyStudent')->name('students.delete');
				Route::delete('delete/{id}/studies/{study_id}','ClassroomController@destroyStudy')->name('studies.delete');
			});
		});

		Route::middleware('role:siswa')->prefix('student')->namespace('Student')->name('students.')->group(function(){
			Route::prefix('exams')->name('exams.')->group(function(){
				Route::get('/','ExamController@index')->name('index');
				Route::get('show/{exam}','ExamController@show')->name('show');
				Route::get('show/{exam}/result/{student}','ExamController@result')->name('result');
			});
			Route::get('/assignments','AssignmentController@index')->name('assignments.index');
			Route::get('/virtual-class','HomeController@index')->name('virtual-class.index');
		});

		Route::middleware('role:guru')->prefix('teacher')->namespace('Teacher')->name('teachers.')->group(function(){
			Route::prefix('questions')->name('questions.')->group(function(){
				Route::get('/','QuestionController@index')->name('index');
				Route::get('create','QuestionController@create')->name('create');
				Route::get('edit/{question}','QuestionController@edit')->name('edit');
				Route::get('show/{question}','QuestionController@show')->name('show');
				Route::get('show/{question}/answer/create','QuestionController@createAnswer')->name('answer.create');
				Route::get('show/{question}/answer/{answer}/update','QuestionController@setAnswer')->name('answer.update');
				Route::post('store','QuestionController@store')->name('store');
				Route::post('store-answer','QuestionController@storeAnswer')->name('answer.store');
				Route::put('update','QuestionController@update')->name('update');
				Route::delete('delete','QuestionController@destroy')->name('delete');
				Route::delete('delete-answer','QuestionController@destroyAnswer')->name('answer.delete');
			});

			Route::prefix('exams')->name('exams.')->group(function(){
				Route::get('/','ExamController@index')->name('index');
				Route::get('create','ExamController@create')->name('create');
				Route::get('edit/{exam}','ExamController@edit')->name('edit');
				Route::get('show/{exam}','ExamController@show')->name('show');
				Route::get('show/{exam}/result/{student}','ExamController@result')->name('result');
				Route::post('save-result','ExamController@saveResult')->name('save-result');
				Route::post('store','ExamController@store')->name('store');
				Route::post('publish','ExamController@publish')->name('publish');
				Route::put('update','ExamController@update')->name('update');
				Route::delete('delete','ExamController@destroy')->name('delete');

				Route::prefix('items')->name('items.')->group(function(){
					Route::get('{exam}','ExamItemController@index')->name('index');
					Route::get('{exam}/create','ExamItemController@create')->name('create');
					Route::post('{exam}/store','ExamItemController@store')->name('store');
					Route::delete('{exam}/delete','ExamItemController@destroy')->name('delete');
				});
			});

			Route::get('/assignments','HomeController@index')->name('assignments.index');
			Route::get('/assessments',function(){
				return "<h2>Coming soon</h2>";
			})->name('assessments.index');
			Route::get('/virtual-class',function(){
				return "<h2>Coming soon</h2>";
			})->name('virtual-class.index');
		});

		Route::middleware('role:wali_kelas')->prefix('counselor')->namespace('Counselor')->name('counselors.')->group(function(){
			Route::get('/students',function(){
				return "<h2>Coming soon</h2>";
			})->name('students.index');
			Route::get('/questions',function(){
				return "<h2>Coming soon</h2>";
			})->name('assessments.index');
			Route::get('/exams',function(){
				return "<h2>Coming soon</h2>";
			})->name('absences.index');
			Route::get('/assignments',function(){
				return "<h2>Coming soon</h2>";
			})->name('reports.index');
		});


		Route::get('profile','HomeController@profile')->name('profile');
		Route::post('profile-update','HomeController@profileUpdate')->name('profile.update');
		Route::post('profile-upload','HomeController@profileUpload')->name('profile.upload');

	});
});
