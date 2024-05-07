<?php

use App\Http\Controllers\ConsoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TabController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use PhpMyAdmin\Controllers\NavigationController;

Route::post('/write_nav', [NavController::class,'sortWrite'])->name('writeForm');
Route::post('/write_tab', [TabController::class,'sortWrite'])->name('writeTab');


Route::post('admin/test', function () {
    [ConsoleController::class, 'testPost'];
    return response()->json(['status' => 'hit test'], 200);
});

Route::post('admin/off', function () {
    Auth::logout();
    return redirect()->back();
});

Route::post('admin/on', function () {
    $username = 'super';
    $password = '123';
    
    if (Auth::attempt(['name' => $username, 'password' => $password])) {
        return redirect()->back();
    } 
    return response()->json(['status' => 'login_failed'], 401);
});


// these might be better placed in there respective sections.  page, slide, etc.
//  CREATE AND DELETE FOR PAGES
Route::post('/create_slideshow', [SlideController::class, 'createSlideshow'])->name('create_slideshow');
Route::post('/create_one_column', [ArticleController::class, 'createOneColumn'])->name('create_one_column');
Route::post('/create_two_column', [ArticleController::class, 'createTwoColumn'])->name('create_two_column');
Route::post('/create_tabbed', [TabController::class, 'createTabbed'])->name('createTabbed');
Route::post('/create_image_article', [ArticleController::class, 'createImageArticle'])->name('create_image_article');

Route::post('/delete_row', [PageController::class, 'deleteRow'])->name('deleteRow');
Route::get('/delete_row_form', function () {
    return View::make('app.layouts.partials.delete_row_form');
})->name('deleteRowForm');

Route::post('/delete_page', [PageController::class, 'deletePage'])->name('deletePage');
Route::get('/delete_page_form', function () {
    return View::make('app.layouts.partials.delete_page_form');
})->name('deletePageForm');

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
Route::post('page_edit/create_new/{returnTo}', [PageController::class, 'createPage'])->name('createPage');


//ARTICLES   
Route::get('/insert_update_article', function () {
    return View::make('articles.editColumn');
})->name('insertUpdateArticle');

Route::post('/submit_update_article', [ArticleController::class, 'updateArticle'])->name('submitUpdateArticle');



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

//which is it??/
Route::get('/load_tab/no_tab_assigned',function () {
    return View::make('tabs.no_tab_assigned');
})->name('displayNoTabs');

Route::get('/no_tab_assigned',function () {
    View::make('tabs.no_tab_assigned');
})->name('noTabAssigned');
// two routes returning the same thing??

Route::post('/quick_tab_asign', [TabController::class, 'quickAssign'])->name('QuickTabAssign');
Route::get('/edit_tabs', function () {
    return View::make('tabs.edit_tabs_form');
})->name('editTabs');

Route::post('/update_tabs', [TabController::class, 'updateTabs'])->name('update_tabs');

Route::get('/load_tab/{routeName}', [TabController::class, 'loadTabContent']);

//this should be renamed to tab/change_tracked
Route::post('/tab/new/{tabId}', function ($tabId) {
    Session::put('tabId', $tabId);
    return response()->json(['message' => $tabId .'Session variable changed successfully']);
})->name('newTabId');


//SLIDES
Route::get('/dispay_slide_data', function () {
    return View::make('slides.slide_data_form');
})->name('dispaySlideData');
Route::get('/slideshow_edit', function () {
    return View::make('slides.editor_layout');
})->name('slideShowEdit');
Route::post('/update_slideshow', [SlideController::class, 'updateSlideshow'])->name('updateSlideshow');



// PAGES AND ROWS


//not sure if change location is being used??
Route::get('/changelocation/{location}', function ($location = null) {
    Session::put('location', $location);
    return response()->json(['message' => 'Session variable changed successfully']);
})->name('changeLocation');

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

// Route::get('/delete_nav_item', function () {
//     return View::make('nav.confirm_delete_nav');
// })->name('deleteNavItem');

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

Route::get('/form/edit_nav_standard/{page?}', function ($page = null) {
    return view('app.first_page', ['page' => $page]);
})->name('newFetch');

Route::get('/', function () {
    return View::make('app.opener');
})->name('opener');

Route::get('/session/{newLocation?}', function ($newLocation = null) {
    return view('app.session', ['newLocation' => $newLocation]);
})->name('sessionSet');

Route::get('/{newLocation?}', function ($newLocation = null) {
    return view('app.site2', ['newLocation' => $newLocation]);
})->name('root');

Route::get('test_fetch/{action?}', function ($action = null) {
    return view('app.test_fetch', ['action' => $action]);
})->name('testFetch');



Route::get('/site2/site', function () {
    return View::make('app.site2');
})->name('site2');

// Route::get('/', function () {
//     return View::make('index');
// })->name('root');

// Route::get('/load_anything', function () {
//     return '<h1>This is HTML content</h1><p>You can return any valid HTML markup here.</p>';
// });


// Route::get('/page_builder/{newLocation?}', function ($newLocation = null) {
//     return view('app.page_builder', ['newLocation' => $newLocation]);
// })->name('pageBuilder');

// Route::get('/open_base_modal', function () {
//     return View::make('forms.base_modal');
// })->name('openBaseModal');


// Route::get('/load_anything', function () {
//     return '<h1>This is HTML content</h1><p>You can return any valid HTML markup here.</p>';
// });



Route::get('/read_/{formName}', function ($formName) {
    if (strpos($formName, 'nav') !== false) {
        $htmlResponse = NavController::sortRead($formName);
        return $htmlResponse;
    } else {
        // Handle other cases here if needed
        return response()->json(['error' => 'Invalid form request'], 400);
    }
})->name('readForm');


Route::get('/refresh_/{refresh}',function ($refresh) {
    if (strpos($refresh, 'nav') !== false) {
        $htmlResponse = NavController::sortRefresh($refresh);
        return $htmlResponse;
    } elseif (strpos($refresh, 'tab') !== false) {
        $htmlResponse = TabController::sortRefresh($refresh);
        return $htmlResponse;
    } else {
        // Handle other cases here if needed
        return response()->json(['error' => 'Invalid form request'], 400);
    }
})->name('refresh');