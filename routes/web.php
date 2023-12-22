<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;

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

Route::delete('/admin/movies/{id}/destroy',[MovieController::class, 'delete'])->name('admin.delete');
Route::post('/admin/movies/store',[MovieController::class, 'store'])->name('admin.store');
Route::patch('/admin/movies/{id}/update',[MovieController::class, 'update'])->name('admin.update');

Route::get('/sheets',[MovieController::class, 'sheets'])->name('sheets.sheets');
Route::get('/admin/movies/{id}/edit',[MovieController::class, 'edit'])->name('admin.edit');
Route::get('/admin/movies/create',[MovieController::class, 'create'])->name('admin.create');
Route::get('/admin/movies',[MovieController::class, 'adminPage'])->name('admin.home');
Route::get('/movies',[MovieController::class, 'index'])->name('global.index');

/* railway-php05
Route::get('/getPractice', [PracticeController::class, 'getPractice']);
*/

/* railway-php03
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
*/

/* railway-php02
Route::get('/', function () {
    return view('welcome');
});
Route::get('/practice', function () {
    return response('practice');
});
Route::get('/practice2', function () {
    $test = 'practice2';
    return response($test);
});
Route::get('/practice3', function () {
    return response('test');
});
*/