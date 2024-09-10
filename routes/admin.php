<?php 

/** Admin Routes Group */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;


Route::group([
    'roles' => ['admin'],
], static function () {

    Route::get('/', function () {
        return redirect(route('admin.home'));
    });

    Route::get('/home', [HomeController::class, 'viewTemplate'])->name('admin.home');
    Route::get('/image-templates', [HomeController::class, 'getImageTemplates'])->name('admin.image.templates');
    Route::get('/template-form/{p_id}', [HomeController::class, 'dashboard'])->name('admin.template');
    
    Route::post('/template/text/suggestion', [HomeController::class, 'checkTextSuggestion'])->name('admin.template.text.suggestion');
    Route::post('/template/text/suggestion-v2/', [HomeController::class, 'checkTextSuggestionAlbanian'])->name('admin.template.text.suggestion2');
});