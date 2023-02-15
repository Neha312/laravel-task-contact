<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductController;

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
    return view('auth.login');
});
Route::group(['middleware' => 'guest'], function () {
    //login route
    Route::get('login', [UserController::class, 'login_view'])->name('login');
    Route::post('login', [UserController::class, 'login'])->name('login');

    //register route
    Route::get('register', [UserController::class, 'register_view'])->name('register');
    Route::post('register', [UserController::class, 'register'])->name('register');

    //forget password rourte
    Route::get('forget-password', [UserController::class, 'forget']);
    Route::post('forget-password', [UserController::class, 'forgetPassword'])->name('forgetPassword');

    Route::get('reset-password', [UserController::class, 'reset']);
    Route::post('reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [UserController::class, 'home'])->name('home');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    //Change Password route
    Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('update-password');

    //user route-Yajra Datatable
    Route::resource('user-crud', UserController::class);

    //Country Controller Route
    Route::resource('country-crud', CountryController::class);

    //State Controller Route
    Route::resource('state-crud', StateController::class);

    //City Controller Route
    Route::resource('city-crud', CityController::class);

    //Contact Controller Route
    Route::controller(ContactController::class)->group(function () {
        Route::get('Showcontact',  'Showcontact');
        Route::post('Contactcreate', 'Contactcreate');
        Route::get('Contactedit/{id}', 'Contactedit');
        Route::put('Contactupdate/{id}', 'Contactupdate');
        Route::delete('Contactdelete/{id}', 'Contactdelete');
        Route::post('fetch-states', 'fetchState');
        Route::post('fetch-cities', 'fetchCity');
    });

    //member route-Ajax practice
    Route::resource('member-ajax-crud', MemberController::class);
});
