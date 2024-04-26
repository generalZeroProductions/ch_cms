<?php

use App\Http\Controllers\ConsoleController;
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


//  BUILDER ROUTES
Route::post('/create_slideshow', [ConsoleController::class, 'createSlideshow'])->name('create_slideshow');
Route::post('/create_one_column', [ConsoleController::class, 'createOneColumn'])->name('create_one_column');
Route::post('/create_two_column', [ConsoleController::class, 'createTwoColumn'])->name('create_two_column');
Route::post('/create_tabbed', [ConsoleController::class, 'createTabbed'])->name('create_tabbed');
Route::post('/create_image_article', [ConsoleController::class, 'createImageArticls'])->name('create_image_article');



// CONSOLE ROUTING

// Route::get('/console/login', [ConsoleController::class, 'loginForm'])->middleware('guest')->name('login');
Route::post('/console/login', [ConsoleController::class, 'login']);
Route::get('/console/logout', [ConsoleController::class, 'logout']);
Route::get('/console/hash', [ConsoleController::class, 'hashAndLogPassword']);

Route::post('/register', [ConsoleController::class, 'createUser']);

Route::get('/login', function () {
    return View::make('layouts.login');
})->name('login');


Route::get('/changeSlideImage', function () {
    return View::make('console.edit_slide_image');
})->name('changeSlideImage');

Route::get('/dispay_slide_data', function () {
    return View::make('forms.slide_data_form');
})->name('dispay_slide_data');

Route::get('/build', function () {
    return View::make('console.page_builder');
})->name('builder');

Route::get('/row_type', function () {
    return View::make('console.row_select_form');
})->name('rowType');

Route::get('/dashboard', function () {
    return View::make('console.dashboard');
})->name('dashboard');

Route::get('/slideShowEdit', function () {
    return View::make('console.edit_slideshow_form');
})->name('slideShowEdit');


Route::post('/update_slideshow', [ConsoleController::class, 'updateSlideshow'])->name('update_slideshow');


Route::post('/create_page', [ConsoleController::class, 'makeNewPage'])->name('create_page');

//PAGE ROUTING 
Route::get('/title_change', function () {
    return View::make('forms.title_change');
})->name('title_change');

Route::get('/set_mobile', function () {
    return View::make('setMobile');
})->name('setMobile');


Route::get('/load-page/{routeName}', [PageController::class, 'loadPage']);
Route::get('/load-tab/{routeName}', [PageController::class, 'loadTabContent']);

Route::get('/image_upload', function () {
    return View::make('forms.upload_image');
})->name('image_upload');


Route::get('/update_article', function () {
    return View::make('forms.editColumn');
})->name('update_article');


Route::get('/edit_tabs', function () {
    return View::make('forms.edit_tabs_form');
})->name('editTabs');

Route::post('/updatePageTitle', [PageController::class, 'pageTitle'])->name('updatePageTitle');
Route::post('/upload', [PageController::class, 'upload'])->name('upload');
Route::post('/use_image', [PageController::class, 'useImage'])->name('use_image');
Route::post('/update_article', [PageController::class, 'updateArticle'])->name('update_article');
Route::post('/update_tabs', [PageController::class, 'updateTabs'])->name('update_tabs');


// Route::get('/', function () {
//     return View::make('index');
// })->name('root');


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


Route::get('/paginatin_form', function () {
    return View::make('console.pages_pagination');
})->name('paginatin_form');

Route::get('/get-pages', [ConsoleController::class, 'getPages'])->name('get-pages');

Route::get('/screen/get/{route}', function ($route) {
    return view('/screen/get_screen', ['route' => $route]);
})->name('getScreen');

Route::get('/screen/wreck', function(){
    return view('/screen/wreck_session');
})->name('testScreen');

Route::get('/screen/set/{settings?}', function ($settings = null) {
    return view('/screen/set_screen', ['settings' => $settings]);
})->name('setScreen');

Route::get('/{newLocation?}', function ($newLocation = null) {
    return view('index', ['newLocation' => $newLocation]);
})->name('root');



