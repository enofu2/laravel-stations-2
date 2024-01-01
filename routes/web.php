<?php

use App\Http\Controllers\Debug\DebugController;
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

//テスト用のエンドポイント
//「HogeRoute」という名前のメソッドを'/Hoge'にマッピングする
Route::prefix('debug')->name('debug.')->group(function () {
    // $methods = [];
    foreach(get_class_methods(DebugController::class) as $name){
        if(preg_match('/^(.*)Route$/',$name))
        {
            preg_match('/^(.*)Route$/',$name,$match);
            Route::get('/'.$match[1],[DebugController::class,$name])->name($match[1]); 
        }
       
    }
});

//route(/admin/*)
//name(admin.*)
Route::prefix('admin')->name('admin.')->group(function () {
    
    //name(admin.schedules.*)
    Route::name('schedules.')->group(function () {
        //route(/admin/schedules/*)
        Route::prefix('schedules')->group(function () {
            Route::get('/',[ScheduleController::class, 'schedules'])->name('schedules');
            Route::get('/{id}',[ScheduleController::class, 'detail'])->name('detail');
            Route::patch('/{id}/update',[ScheduleController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy',[ScheduleController::class, 'delete'])->name('delete');
            Route::get('/{scheduleId}/edit',[ScheduleController::class, 'edit'])->name('edit');
        });
        
        //route(/admin/movies/*)
        Route::prefix('movies')->group(function () {
            Route::get('/{id}/schedules/create',[ScheduleController::class, 'create'])->name('create');
            Route::post('/{id}/schedules/store',[ScheduleController::class, 'store'])->name('store');
        });

    });

    //name(admin.reservations.*)
    Route::name('reservations.')->group(function () {
        //route(/admin/reservations/*)
        Route::prefix('reservations')->group(function () {
            Route::get('/',[ReservationController::class, 'adminReservations'])->name('reservations');
            Route::post('/',[ReservationController::class, 'adminStore'])->name('store');
            Route::delete('/{id}',[ReservationController::class, 'adminDelete'])->name('delete');
            Route::patch('/{id}',[ReservationController::class, 'adminUpdate'])->name('update');
            Route::get('/create',[ReservationController::class, 'adminCreate'])->name('create');
            Route::get('/{id}/edit',[ReservationController::class, 'adminEdit'])->name('edit');
        });
    });

    //name(admin.movies.*)
    Route::name('movies.')->group(function () {
        //route(/admin/movies/*)
        Route::prefix('movies')->group(function () {
            Route::get('/',[MovieController::class, 'movies'])->name('movies');
            Route::get('/{id}/edit',[MovieController::class, 'edit'])->name('edit');
            Route::get('/create',[MovieController::class, 'create'])->name('create');
            Route::get('/{id}',[MovieController::class, 'detailAdmin'])->name('detail');
            Route::post('/store',[MovieController::class, 'store'])->name('store');
            Route::patch('/{id}/update',[MovieController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy',[MovieController::class, 'delete'])->name('delete');
        });
    });
});

//name(sheets.*)
Route::name('sheets.')->group(function () {
    Route::get('sheets/',[SheetController::class, 'sheets'])->name('sheets');
    Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets',[SheetController::class, 'sheetsForReservation'])->name('detail');
});

//name(reservations.*)
Route::name('reservations.')->group(function () {
    Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create',[ReservationController::class, 'create'])->name('create');
    Route::post('/reservations/store',[ReservationController::class, 'store'])->name('store');
});

//name(sheets.*)
Route::name('movies.')->group(function () {
    Route::get('/movies',[MovieController::class, 'index'])->name('index');
    Route::get('/movies/{id}',[MovieController::class, 'detail'])->name('detail');
});

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