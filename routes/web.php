<?php

use Illuminate\Http\Request;  // Shto këtë në fillim
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\InfoLogController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';
Route::namespace('App\Http\Controllers')->controller(DashboardController::class)->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    })->name('/');
    Route::get('/template-form/{p_id}', 'dashboard')->name('dashboard.template');
    Route::post('/store', 'store')->name('dashboard.store');
});

 Route::get('/admin', function () {
    return view('calander');
});

//Route::post('/log-error', function(Request $request) {
//    \Log::error($request->error);
//});

Route::post('/log-error', [ErrorLogController::class, 'logError'])->name('log.error');
Route::post('/log-info', [InfoLogController::class, 'logInfo'])->name('log.info');


