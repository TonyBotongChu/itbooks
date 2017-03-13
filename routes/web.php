<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('navigate', "NavigationController@navigate")->name('navigate');

Route::get('like', "LikeController@like")->name('like');
Route::get('unlike', "LikeController@unlike")->name('unlike');
Route::get('read', "ReadController@read")->name('read');
Route::get('unread', "ReadController@unread")->name('unread');

Route::group(['prefix'=>'conference'], function(){
	Route::get('/', 'ConferenceController@index')->name('conference.index');
	Route::get('{id}', 'ConferenceController@show')->name('conference.show');
	Route::post('{id}/register', 'ConferenceController@postRegister')->name('conference.register');
	Route::post('{id}/cancel', 'ConferenceController@postCancel')->name('conference.cancel');
});

Route::resource('resource', 'ResourceController');
Route::post('resource/{id}/download', 'ResourceController@postDownload')->name("resource.download"); // TODO: 增加支付积分逻辑，增加支付路由(getDownload)，编写下载逻辑

/* get image from storage */
Route::get('image/{src?}', function ($src){
    return Image::make(storage_path($src))->response();
})->where('src', '(.*)')->name('image');

/* book module for users */
Route::group(["prefix"=>"book"], function(){
	Route::get("/", "BookController@index")->name("book.index");
	Route::get("{id}", "BookController@show")->name("book.show");
	Route::get('{id}/updatekj', 'BookController@updateKejian')->name('book.updatekj');
	Route::get('search', 'BookController@search')->name('book.search');
});

/* book request module for users*/
//Route::resource('bookreq', 'BookRequestController');
Route::group(["prefix"=>"bookreq"], function(){
	Route::get("/","BookRequestController@index")->name("bookreq.index");
	Route::post('store/multiple',"BookRequestController@storeMultiple")->name('bookreq.store.multiple');
	Route::get("/record", "BookRequestController@record")->name("bookreq.record");
	Route::get("create/{book_id}", "BookRequestController@create")->name("bookreq.create");
	Route::get("{id}", "BookRequestController@show")->name("bookreq.show");
	Route::post("store", "BookRequestController@store")->name("bookreq.store");
	Route::delete("/{id}/destroy", "BookRequestController@destroy")->name("bookreq.destroy");
	// Users do not have the access to edit/update an book request;
});

/* user certification module */
Route::resource('cert', 'CertificationController');


Route::get('/', function () {
	return view('welcome',['message'=>'欢迎来到书圈!']);
})->name('index');
Route::get('/errors',"PermissionController@user_permission_error")->name('errors.index');

Route::get('/home', 'HomeController@index');
Auth::routes();

/**
 * wechat routes
 */
Route::group(["prefix" => "wechat"], function(){
	Route::get("/","WechatController@index");
    Route::post("/","WechatController@server");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// admin dashboard routes:
Route::group(["prefix" => "admin",'middleware' => ['auth']], function(){

	Route::get('/',function (){
		return view('admin.index');
	})->name('admin.index');
	Route::get('/errors',"PermissionController@admin_permission_error")->name('admin.errors.index');
	Route::post('/logout','Admin\AdminAuthController@logout')->name('admin.logout');

	Route::get('bookreq', 'BookRequestAdminController@getIndex')->name('admin.bookreq.index');
	Route::get('bookreq/{id}', 'BookRequestAdminController@show')->name('admin.bookreq.show');
	Route::post('bookreq/{id}/pass', 'BookRequestAdminController@pass')->name('admin.bookreq.pass');
	Route::post('bookreq/{id}/reject', 'BookRequestAdminController@reject')->name('admin.bookreq.reject');
	Route::delete('bookreq/{id}', 'BookRequestAdminController@destroy')->name('admin.bookreq.destroy');

	Route::get('cert', 'CertificationAdminController@index')->name('admin.cert.index');
	Route::get('cert/{id}', 'CertificationAdminController@show')->name('admin.cert.show');
	Route::post('cert/{id}/pass', 'CertificationAdminController@pass')->name('admin.cert.pass');
	Route::post('cert/{id}/reject', 'CertificationAdminController@reject')->name('admin.cert.reject');
	Route::post('cert/{id}/deprive', 'CertificationAdminController@deprive')->name('admin.cert.deprive');
	Route::delete('cert/{id}', 'CertificationAdminController@destroy')->name('admin.cert.destroy');
	
	Route::group(['prefix'=>'book'], function(){
		Route::get('/', 'BookAdminController@index')->name('admin.book.index');
		Route::post('/', 'BookAdminController@store')->name('admin.book.store');
		Route::get('create', 'BookAdminController@create')->name('admin.book.create');
		Route::get('{id}', 'BookAdminController@show')->name('admin.book.show');
		Route::put('{id}', 'BookAdminController@update')->name('admin.book.update');
		Route::delete('{id}', 'BookAdminController@destroy')->name('admin.book.destroy');
		Route::get('{id}/edit', 'BookAdminController@edit')->name('admin.book.edit');
		Route::get('import', 'DatabaseController@importBooks')->name('admin.book.import');
		Route::get('{id}/updatekj', 'BookAdminController@updateKejian')->name('admin.book.updatekj');
	});

	Route::group(['prefix'=>'resource'], function(){
		Route::get('/', 'ResourceAdminController@index')->name('admin.resource.index');
		Route::post('/', 'ResourceAdminController@store')->name('admin.resource.store');
		Route::get('create', 'ResourceAdminController@create')->name('admin.resource.create');
		Route::get('{id}', 'ResourceAdminController@show')->name('admin.resource.show');
		Route::put('{id}', 'ResourceAdminController@update')->name('admin.resource.update');
		Route::delete('{id}', 'ResourceAdminController@destroy')->name('admin.resource.destroy');
		Route::get('{id}/edit', 'ResourceAdminController@edit')->name('admin.resource.edit');
		Route::post('{id}/download', 'ResourceAdminController@postDownload')->name('admin.resource.download');
	});

	/*
	 * user routes
	 */
	Route::group(['prefix'=>'user'],function (){
		Route::get('/', 'Admin\AdminUserController@index')->name("admin.user.index");

		Route::post('/create','Admin\AdminUserController@create')->name('admin.user.create');
	});

	Route::group(['prefix'=>'department'],function (){
		Route::get('/','Admin\DepartmentController@index')->name('admin.department.index');
		Route::get('/{department_code}','Admin\DepartmentController@showDepartment')->name('admin.department.show');

		Route::post('/create','Admin\DepartmentController@createDepartment')->name('admin.department.create');
		Route::post('/{department_code}/update','Admin\DepartmentController@updateDepartment')->name('admin.department.update');
		Route::post('/{department_code}/office/delete','Admin\DepartmentController@deleteOffice')->name('admin.office.delete');
	});

	Route::group(['prefix'=>'conference'], function(){
		Route::get('/', 'ConferenceAdminController@index')->name('admin.conference.index');
		Route::post('/', 'ConferenceAdminController@store')->name('admin.conference.store');
		Route::get('create', 'ConferenceAdminController@create')->name('admin.conference.create');
		Route::get('{id}', 'ConferenceAdminController@show')->name('admin.conference.show');
		Route::put('{id}', 'ConferenceAdminController@update')->name('admin.conference.update');
		Route::delete('{id}', 'ConferenceAdminController@destroy')->name('admin.conference.destroy');
		Route::get('{id}/edit', 'ConferenceAdminController@edit')->name('admin.conference.edit');
		Route::get('{id}/export', "DatabaseController@exportConferenceRegisters")->name('admin.conference.export');
	});
});

Route::group(['prefix'=>'user','middleware' => ['auth']],function (){
	Route::get('/',"UserController@index")->name('user.index');
	Route::get('/teacher',"UserController@teacher")->name('user.teacher.index');
	Route::get('/email',"UserController@email")->name('user.email');
	Route::post('/email/store','UserController@storeEmail')->name('user.email.store');
	Route::get('/email/send_cert',"UserController@sendEmailCert")->name('user.email.send_cert');
	Route::get('/address','UserController@address')->name('user.address.index');
});

Route::get('test', function(){
	return view('test');
});

Route::group(["prefix" => "email"],function (){
	Route::get('/send','MailController@send');
	Route::get('/certificate/{token}',"MailController@certificate")->name('email.certificate');
});

Route::group(["prefix" => "message"],function (){
	Route::get('/',"MessageController@index")->name('message.index');
});