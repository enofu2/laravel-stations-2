<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SheetController;

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

Route::get('/admin/schedules',[ScheduleController::class, 'schedules'])->name('admin.schedule.schedules');
Route::get('/admin/schedules/{id}',[ScheduleController::class, 'detail'])->name('admin.schedule.detail');
Route::get('/admin/movies/{id}/schedules/create',[ScheduleController::class, 'create'])->name('admin.schedule.create');
Route::get('/admin/schedules/{scheduleId}/edit',[ScheduleController::class, 'edit'])->name('admin.schedule.edit');
Route::post('/admin/movies/{id}/schedules/store',[ScheduleController::class, 'store'])->name('admin.schedule.store');
Route::patch('/admin/schedules/{id}/update',[ScheduleController::class, 'update'])->name('admin.schedule.update');
Route::delete('/admin/schedules/{id}/destroy',[ScheduleController::class, 'delete'])->name('admin.schedule.delete');

Route::get('/sheets',[SheetController::class, 'sheets'])->name('sheets.sheets');
Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets',[SheetController::class, 'sheetsForReservation'])->name('sheets.detail');

Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create',[ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations/store',[ReservationController::class, 'store'])->name('reservations.store');
Route::get('/admin/reservations',[ReservationController::class, 'adminReservations'])->name('admin.reservations.reservations');
Route::get('/admin/reservations/create',[ReservationController::class, 'adminCreate'])->name('admin.reservations.create');
Route::get('/admin/reservations/{id}/edit',[ReservationController::class, 'adminEdit'])->name('admin.reservations.edit');
Route::delete('/admin/reservations/{id}',[ReservationController::class, 'adminDelete'])->name('admin.reservations.delete');
Route::patch('/admin/reservations/{id}',[ReservationController::class, 'adminUpdate'])->name('admin.reservations.update');
Route::post('/admin/reservations',[ReservationController::class, 'adminStore'])->name('admin.reservations.store');

Route::get('/movies',[MovieController::class, 'index'])->name('movie.index');
Route::get('/movies/{id}',[MovieController::class, 'detail'])->name('movie.detail');
Route::get('/admin/movies/{id}/edit',[MovieController::class, 'edit'])->name('admin.edit');
Route::get('/admin/movies/create',[MovieController::class, 'create'])->name('admin.create');
Route::get('/admin/movies/{id}',[MovieController::class, 'detailAdmin'])->name('admin.movie.detail');
Route::get('/admin/movies',[MovieController::class, 'movies'])->name('admin.home');
Route::post('/admin/movies/store',[MovieController::class, 'store'])->name('admin.store');
Route::patch('/admin/movies/{id}/update',[MovieController::class, 'update'])->name('admin.update');
Route::delete('/admin/movies/{id}/destroy',[MovieController::class, 'delete'])->name('admin.delete');


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