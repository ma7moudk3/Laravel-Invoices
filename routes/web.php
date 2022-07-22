<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/invoices', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices');
Route::get('/sections', [App\Http\Controllers\SectionsController::class, 'index'])->name('sections');
Route::get('/{page}', "App\Http\Controllers\AdminController@index",);
Route::resource('sections', "App\Http\Controllers\SectionsController");
