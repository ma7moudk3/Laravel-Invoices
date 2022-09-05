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
Route::group(["namespace" => "sections", "prefix" => "sections"], function () {
    Route::get('/', [App\Http\Controllers\SectionsController::class, 'index'])->name('sections');
    Route::post('/update', [App\Http\Controllers\SectionsController::class, 'edit'])->name('sections.update');
    Route::post('/store', [App\Http\Controllers\SectionsController::class, 'store'])->name('sections.store');
    Route::post('/destroy', [App\Http\Controllers\SectionsController::class, 'destroy'])->name('sections.destroy');

    Route::get('/{id}', [App\Http\Controllers\InvoicesController::class, 'getProducts'])->name('sections');

});
Route::group(["namespace" => "products", "prefix" => "products"], function () {
    Route::get('/', [App\Http\Controllers\ProductsController::class, 'index'])->name('products');
    Route::post('/update', [App\Http\Controllers\ProductsController::class, 'edit'])->name('products.update');
    Route::post('/store', [App\Http\Controllers\ProductsController::class, 'store'])->name('products.store');
    Route::post('/destroy', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('products.destroy');
});


Route::group(["namespace" => "invoices", "prefix" => "invoices"], function () {
    Route::get('/', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices');
    Route::get('/create', [App\Http\Controllers\InvoicesController::class, 'create'])->name('invoices.create');
    Route::get('/store', [App\Http\Controllers\InvoicesController::class, 'store'])->name('invoices.store');

});


Route::get('/{page}', "App\Http\Controllers\AdminController@index",);
//Route::resource('sections', "App\Http\Controllers\SectionsController");
