<?php 

/** Admin Routes Group */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\UserController;


Route::group([
    'roles' => ['superadmin'],
], static function () {

    Route::get('/', function () {
        return redirect(route('superadmin.home'));
    });

    Route::get('/home', [UserController::class, 'getHome'])->name('superadmin.home');
    Route::get('/customers', [UserController::class, 'getCustomers'])->name('superadmin.customers');
    Route::get('/costumer-create', [UserController::class, 'createCostumer'])->name('superadmin.costumer-create');
    Route::post('/costumer-store', [UserController::class, 'storeCostumer'])->name('superadmin.costumer.store');
    Route::post('/costumer-remove', [UserController::class, 'removeCostumer'])->name('superadmin.costumer.remove');
    Route::get('/costumer-edit/{id}', [UserController::class, 'editCostumer'])->name('superadmin.costumer.edit');
    Route::post('/costumer-update', [UserController::class, 'updateCostumer'])->name('superadmin.costumer.update');
    
});