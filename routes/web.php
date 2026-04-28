<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Website Dharmayukti Karini
|--------------------------------------------------------------------------
*/

// ====== PUBLIC ROUTES ======
Route::get('/', 'HomeController@index')->name('home');
Route::get('/berita', 'PostController@index')->name('berita');
Route::get('/berita/{slug}', 'PostController@show')->name('berita.detail');
Route::get('/profil', 'HomeController@profil')->name('profil');
Route::get('/profil/{slug}', 'HomeController@profilShow')->name('profil.show');
Route::get('/kontak', 'HomeController@kontak')->name('kontak');

// ====== AUTH ROUTES ======
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ====== ADMIN ROUTES ======
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
    Route::post('/editor/upload', 'Admin\EditorUploadController@store')->name('editor.upload');

    // Posts
    Route::get('/posts', 'Admin\PostController@index')->name('posts.index');
    Route::get('/posts/create', 'Admin\PostController@create')->name('posts.create');
    Route::post('/posts', 'Admin\PostController@store')->name('posts.store');
    Route::get('/posts/{id}/edit', 'Admin\PostController@edit')->name('posts.edit');
    Route::put('/posts/{id}', 'Admin\PostController@update')->name('posts.update');
    Route::delete('/posts/{id}', 'Admin\PostController@destroy')->name('posts.destroy');

    // Categories (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/profile-pages', 'Admin\ProfilePageController@index')->name('profile-pages.index');
        Route::get('/profile-pages/create', 'Admin\ProfilePageController@create')->name('profile-pages.create');
        Route::post('/profile-pages', 'Admin\ProfilePageController@store')->name('profile-pages.store');
        Route::get('/profile-pages/{id}/edit', 'Admin\ProfilePageController@edit')->name('profile-pages.edit');
        Route::put('/profile-pages/{id}', 'Admin\ProfilePageController@update')->name('profile-pages.update');
        Route::delete('/profile-pages/{id}', 'Admin\ProfilePageController@destroy')->name('profile-pages.destroy');

        Route::get('/agendas', 'Admin\AgendaController@index')->name('agendas.index');
        Route::get('/agendas/create', 'Admin\AgendaController@create')->name('agendas.create');
        Route::post('/agendas', 'Admin\AgendaController@store')->name('agendas.store');
        Route::get('/agendas/{id}/edit', 'Admin\AgendaController@edit')->name('agendas.edit');
        Route::put('/agendas/{id}', 'Admin\AgendaController@update')->name('agendas.update');
        Route::delete('/agendas/{id}', 'Admin\AgendaController@destroy')->name('agendas.destroy');

        Route::get('/sliders', 'Admin\SliderController@index')->name('sliders.index');
        Route::get('/sliders/create', 'Admin\SliderController@create')->name('sliders.create');
        Route::post('/sliders', 'Admin\SliderController@store')->name('sliders.store');
        Route::get('/sliders/{id}/edit', 'Admin\SliderController@edit')->name('sliders.edit');
        Route::put('/sliders/{id}', 'Admin\SliderController@update')->name('sliders.update');
        Route::delete('/sliders/{id}', 'Admin\SliderController@destroy')->name('sliders.destroy');

        Route::get('/categories', 'Admin\CategoryController@index')->name('categories.index');
        Route::post('/categories', 'Admin\CategoryController@store')->name('categories.store');
        Route::put('/categories/{id}', 'Admin\CategoryController@update')->name('categories.update');
        Route::delete('/categories/{id}', 'Admin\CategoryController@destroy')->name('categories.destroy');

        Route::get('/users', 'Admin\UserController@index')->name('users.index');
        Route::get('/users/create', 'Admin\UserController@create')->name('users.create');
        Route::post('/users', 'Admin\UserController@store')->name('users.store');
        Route::get('/users/{id}/edit', 'Admin\UserController@edit')->name('users.edit');
        Route::put('/users/{id}', 'Admin\UserController@update')->name('users.update');
        Route::delete('/users/{id}', 'Admin\UserController@destroy')->name('users.destroy');
    });
});
