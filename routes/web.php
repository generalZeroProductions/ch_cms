<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PageController;

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

Route::get('/', function () {
    return view('index');
});


 //PAGE ROUTING 
// Route::get('/load-page/{routeName}', function ($routeName) {
//     dd($routeName);
// });
// Route::get('/load-page/{routeName}', function ($routeName) {
//     $viewPath = 'rows.' . $routeName; // Adjust the path to match your views directory structure
//     if (view()->exists($viewPath)) {
//         return View::make($viewPath);
//     } else {
//         abort(404); // or handle the error appropriately
//     }
// });  updateArticle

Route::get('/', function () {
    return View::make('index');
})->name('root');
Route::get('/load-page/{routeName}', [PageController::class, 'loadPage']);

Route::get('/image_upload', function () {
    return View::make('forms.upload_image');
})->name('image_upload');
Route::get('/update_article', function () {
    return View::make('forms.editColumn');
})->name('update_article');

Route::post('/upload', [PageController::class, 'upload'])->name('upload');
Route::post('/update_article', [PageController::class, 'updateArticle'])->name('update_article');





//  NAV ROUTES
Route::get('/edit_nav_item', function () {
    return View::make('forms.edit_nav_form');
})->name('editNavItem');

Route::get('/add_nav_select', function () {
    return View::make('forms.add_nav_select_form');
})->name('addNavSelect');

Route::get('/add_nav_standard', function () {
    return View::make('forms.add_nav_form');
})->name('addNavStandard');

Route::get('/delete_nav_item', function () {
    return View::make('forms.confirm_delete_nav');
})->name('deleteNavItem');

Route::get('/open_base_modal', function () {
    return View::make('forms.base_modal');
})->name('openBaseModal');

Route::get('/dropdown_editor', function () {
    return View::make('forms.edit_drop_down');
})->name('dropdown_editor');

Route::get('/dropdown_adder', function () {
    return View::make('forms.add_dropdown_form');
})->name('dropdown_adder');

Route::post('/update_nav_item', [NavController::class, 'updateNavItem'])->name('updateNavItem');

Route::post('/new_nav_item', [NavController::class, 'newNavItem'])->name('newNavItem');

Route::post('/delete_nav_item', [NavController::class,'deleteItem'])->name('delete_nav_item');

Route::post('/update_drop_nav', [NavController::class,'updateDrop'])->name('update_drop_nav');
Route::post('/add_drop_nav', [NavController::class,'addDropdown'])->name('add_drop_nav');

