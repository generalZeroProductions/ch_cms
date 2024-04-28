<?php

use App\Http\Controllers\ConsoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TabController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;


//  BUILDER ROUTES
Route::post('/create_slideshow', [SlideController::class, 'createSlideshow'])->name('create_slideshow');
Route::post('/create_one_column', [ArticleController::class, 'createOneColumn'])->name('create_one_column');
Route::post('/create_two_column', [ArticleController::class, 'createTwoColumn'])->name('create_two_column');
Route::post('/create_tabbed', [ConsoleController::class, 'createTabbed'])->name('create_tabbed');
Route::post('/create_image_article', [ConsoleController::class, 'createImageArticls'])->name('create_image_article');

Route::get('/editBlade', function () {
    return View::make('slides.editor_layout');
})->name('editBlade');

// CONSOLE ROUTING
Route::get('/console/logout', [ConsoleController::class, 'logout']);
Route::get('/console/hash', [ConsoleController::class, 'hashAndLogPassword']);
Route::get('/login', function () {
    return View::make('console.login');
})->name('login');

Route::get('/dashboard', function () {
    return View::make('console.dashboard');
})->name('dashboard');

Route::get('/pagination_form', function () {
    return View::make('console.page_pagination_form');
})->name('paginationForm');

Route::get('/display_all_pages', [ConsoleController::class, 'displayAllPages'])->name('displayAllPages');
Route::post('console/register', [ConsoleController::class, 'createUser']);
Route::post('/console/login', [ConsoleController::class, 'login']);
Route::post('page_edit/create_new', [PageController::class, 'createPage'])->name('createPage');


//ARTICLES   
Route::get('/update_article', function () {
    return View::make('articles.editColumn');
})->name('update_article');
Route::post('/update_article', [ArticleController::class, 'updateArticle'])->name('update_article');



//IMAGES
Route::get('/select_image_upload', function () {
    return View::make('images.upload_image');
})->name('select_image_upload');

Route::get('/change_slide_image', function () {
    return View::make('images.edit_slide_image');
})->name('changeSlideImage');
Route::post('/upload_image', [ImageController::class, 'uploadImage'])->name('uploadImage');
Route::post('/use_image', [ImageController::class, 'useImage'])->name('use_image');

Route::get('/insert_image_icons_3', function () {
    return View::make('images.partials.image_icons_3');
})->name('insertImageIcons3');

Route::get('/insert_upload_file', function () {
    return View::make('images.partials.upload_file_bar');
})->name('insertUploadFile');

Route::get('/insert_file_select', function () {
    return View::make('images.partials.select_file_bar');
})->name('insertFileSelect');

Route::get('/insert_slide_card', function () {
    return View::make('images.partials.image_preview_card');
})->name('insertSlideCard');

Route::get('/insert_add_image_card', function () {
    return View::make('images.partials.add_slide_card');
})->name('insertAddImageCard');


//TABS
Route::get('/load_tab/{routeName}', [TabController::class, 'loadTabContent']);
Route::get('/edit_tabs', function () {
    return View::make('tabs.edit_tabs_form');
})->name('editTabs');
Route::post('/update_tabs', [TabController::class, 'updateTabs'])->name('update_tabs');


//SLIDES
Route::get('/dispay_slide_data', function () {
    return View::make('slides.slide_data_form');
})->name('dispaySlideData');
Route::get('/slideshow_edit', function () {
    return View::make('slides.editor_layout');
})->name('slideShowEdit');
Route::post('/update_slideshow', [SlideController::class, 'updateSlideshow'])->name('updateSlideshow');



// PAGES AND ROWS
Route::get('/load_page/{routeName}', [PageController::class, 'loadPage']);

Route::get('/title_change', function () { 
    return View::make('app.layouts.partials.title_change');
})->name('titleChange');

Route::get('/build', function () {
    return View::make('app.page_builder');
})->name('builder');
Route::get('/row_type', function () {
    return View::make('forms.row_select_form');
})->name('rowType');


Route::post('/update_page_title', [PageController::class, 'updatePageTitle'])->name('updatePageTitle');






//  NAV ROUTES
Route::get('/edit_nav_item', function () {
    return View::make('nav.edit_nav_form');
})->name('editNavItem');

Route::get('/add_nav_select', function () {
    return View::make('nav.add_nav_select_form');
})->name('addNavSelect');

Route::get('/add_nav_standard', function () {
    return View::make('nav.add_nav_form');
})->name('addNavStandard');

Route::get('/delete_nav_item', function () {
    return View::make('nav.confirm_delete_nav');
})->name('deleteNavItem');

Route::get('/dropdown_editor', function () {
    return View::make('nav.edit_drop_down');
})->name('dropdownEditor');

Route::get('/dropdown_adder', function () {
    return View::make('nav.add_dropdown_form');
})->name('dropdownAdder');

Route::post('/update_nav_item', [NavController::class, 'updateNavItem'])->name('updateNavItem');
Route::post('/new_nav_item', [NavController::class, 'newNavItem'])->name('newNavItem');
Route::post('/delete_nav_item', [NavController::class,'deleteNavItem'])->name('deleteNavItem');
Route::post('/update_dropdown', [NavController::class,'updateDropdown'])->name('updateDropdown');
Route::post('/add_dropdown', [NavController::class,'addDropdown'])->name('addDropdown');


// APP LEVEL ROUTES

Route::get('/open_base_modal', function () {
    return View::make('forms.base_modal');
})->name('openBaseModal');

Route::get('/page_builder/{newLocation?}', function ($newLocation = null) {
    return view('app.page_builder', ['newLocation' => $newLocation]);
})->name('pageBuilder');

Route::get('/session/{newLocation?}', function ($newLocation = null) {
    return view('app.session', ['newLocation' => $newLocation]);
})->name('sessionSet');

Route::get('/{newLocation?}', function ($newLocation = null) {
    return view('app.site', ['newLocation' => $newLocation]);
})->name('root');



// Route::get('/', function () {
//     return View::make('index');
// })->name('root');