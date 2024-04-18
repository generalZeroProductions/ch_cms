<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavController;

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

