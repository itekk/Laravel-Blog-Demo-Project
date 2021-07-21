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
    if (Auth::user()) {
        if (Auth::user()->user_type == 'admin') {
            return redirect()->intended('admin/dashboard');
        } elseif (Auth::user()->user_type == 'supervisor') {
            return redirect()->intended('supervisor/dashboard');
        } else {
            return redirect()->intended('blogger/dashboard');
        }
    } else {
        return view('auth.login');
    }
});
Route::get('/login', function () {
    if (Auth::user()) {
        return redirect()->intended(Auth::user()->user_type . '/dashboard');
    } else {
        return view('auth.login');
    }
});

Route::get('/register', function () {
    if (Auth::user()) {
        return redirect()->intended(Auth::user()->user_type . '/dashboard');
    } else {
        return view('auth.register');
    }
})->name('register');
Route::post('/register', 'Auth\RegisterController@create')->name('register-new');

// Authentication routes
Route::post('login', 'Auth\LoginController@authenticate')->name('login');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    // Admin routes
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('admin/dashboard', 'Admin\DashboardController@index')->name('admin-dashboard');
        Route::get('admin/user-list', 'Admin\UserController@index')->name('admin-users');
        Route::get('admin/edit-user/{id}', 'Admin\UserController@edit')->name('edit-user');
        Route::post('admin/edit-user/{id}', 'Admin\UserController@update')->name('update-user');
        Route::get('admin/add-user', 'Admin\UserController@add')->name('add-user');
        Route::post('admin/add-user', 'Admin\UserController@store')->name('create-user');
        Route::get('admin/assign-supervisors', 'Admin\AssignUserController@assignSupervisors')->name('assign-supervisors');
        Route::get('admin/assign-bloggers', 'Admin\AssignUserController@assignBloggers')->name('assign-bloggers');
        Route::post('admin/assign-supervisors', 'Admin\AssignUserController@assignSupervisorsPost')->name('assign-supervisors');
        Route::post('admin/assign-bloggers', 'Admin\AssignUserController@assignBloggersPost')->name('assign-bloggers');
        Route::delete('admin/delete-user/{id}', 'Admin\UserController@delete');
        Route::get('admin/supervisor-list', 'Admin\SupervisorController@index')->name('admin-supervisor');
        Route::get('admin/blogger-list/{id}', 'Admin\SupervisorController@listBloggers')->name('view-bloggers');
        Route::get('admin/blog-list', 'Admin\BlogController@show')->name('admin-blogs');
    });

     // blogger routes
    Route::middleware(['isBlogger'])->group(function () {
        Route::get('blogger/dashboard', 'Blogger\DashboardController@index')->name('blogger-dashboard');
        Route::get('blogger/blog-list', 'Blogger\BlogController@show')->name('blogger-list');
    });

    // supervisor routes
    Route::middleware(['isSupervisor'])->group(function () {
        Route::get('supervisor/dashboard', 'Supervisor\DashboardController@index')->name('supervisor-dashboard');
        Route::get('supervisor/user-list', 'Supervisor\UserController@index')->name('supervisor-user-list');
        Route::get('supervisor/blog-list', 'Supervisor\BlogController@index')->name('supervisor-blog-list');
    });

    // common routes
    Route::get('{userType}/add-blog', 'Common\BlogController@index')->name('add-blog');
    Route::post('{userType}/add-blog', 'Common\BlogController@store')->name('create-blog');

    Route::middleware(['canAccessBlog'])->group(function () {
        Route::get('{userType}/edit-blog/{id}', 'Common\BlogController@update')->name('edit-blog');
        Route::post('{userType}/edit-blog/{id}', 'Common\BlogController@updatePost')->name('update-blog');
        Route::delete('{userType}/delete-blog/{id}', 'Common\BlogController@delete');
        Route::get('{userType}/view-blog/{id}', 'Common\BlogController@show')->name('view-blog');
    });

    Route::post('{userType}/personal-detail-update', 'Common\DashboardController@update')->name('personal-detail-update');
    Route::get('{userType}/change-password', 'Common\DashboardController@changePassword')->name('change-password');
    Route::post('{userType}/change-password', 'Common\DashboardController@changePasswordPost')->name('change-password');
    Route::get('{userType}/no-permission', function () {
        return view('common.no-permission');
    });
});

