<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\kategoriItemsController;
use App\Http\Controllers\MasterItemsController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

route::get('/kategori-items', [App\Http\Controllers\KategoriItemsController::class, 'index']);
route::get('/kategori-items/create', [App\Http\Controllers\KategoriItemsController::class, 'create']);
route::post('/kategori-items/store', [App\Http\Controllers\KategoriItemsController::class, 'store']);
route::get('/kategori-items/edit/{id}', [App\Http\Controllers\KategoriItemsController::class, 'edit']);
route::post('/kategori-items/update/{id}', [App\Http\Controllers\KategoriItemsController::class, 'update']);
route::get('/kategori-items/delete/{id}', [App\Http\Controllers\KategoriItemsController::class, 'destroy']);

route::get('/kategori-items/view/{id}', [App\Http\Controllers\KategoriItemsController::class, 'show']);
Route::get('/kategori-items/{id}/pdf', [App\Http\Controllers\KategoriItemsController::class, 'downloadPdf']);

Route::get('/master-items/export-excel', [App\Http\Controllers\MasterItemsController::class, 'exportExcel']);
route::get('/kategori-items/export-excel', [App\Http\Controllers\MasterItemsController::class, 'exportExcel']);
