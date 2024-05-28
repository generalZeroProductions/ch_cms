<?php

use App\Helpers\PageMaker;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TabController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('footer', function () {
    return View::make('app.footer');
})->name('footer');
// these might be better placed in there respective sections.  page, slide, etc.
//  CREATE AND DELETE FOR PAGES
Route::post('/create_slideshow', [SlideController::class, 'createSlideshow'])->name('create_slideshow');
Route::post('/create_one_column', [ArticleController::class, 'createOneColumn'])->name('create_one_column');
Route::post('/create_two_column', [ArticleController::class, 'createTwoColumn'])->name('create_two_column');
Route::post('/create_tabbed', [TabController::class, 'createTabbed'])->name('createTabbed');
Route::post('/create_image_article', [ArticleController::class, 'createImageArticle'])->name('create_image_article');

Route::post('/delete_row', [PageController::class, 'deleteRow'])->name('deleteRow');

Route::get('/delete_row_form', function () {
    return View::make('app.edit_mode.delete_row_form');
})->name('deleteRowForm');

Route::post('/delete_page', [PageController::class, 'deletePage'])->name('deletePage');

Route::get('/delete_page_form', function () {
    return View::make('app.edit_mode.delete_page_form');
})->name('deletePageForm');

// CONSOLE ROUTING
Route::get('/console/logout', [ConsoleController::class, 'logout']);
Route::get('/console/hash', [ConsoleController::class, 'hashAndLogPassword']);
Route::get('/login', function () {
    return View::make('console.login');
})->name('login');




Route::post('/delete_contact', [ConsoleController::class, 'deleteContact']);
Route::get('/dashboard', function () {
    return View::make('console.dashboard');
})->name('dashboard');

// Route::get('/pagination_form', function () {
//     return View::make('console.page_pagination_form');
// })->name('paginationForm');

Route::get('/delete_contact_form', function () {
    return View::make('app.edit_mode.delete_inq_form');
})->name('paginationForm');

Route::get('/display_all_pages/{index}', [ConsoleController::class, 'displayAllPages'])->name('displayAllPages');
Route::get('/display_all_inquiries/{index}', [ConsoleController::class, 'displayAllInquiries']);
Route::get('/display_all_users/{index}', [ConsoleController::class, 'displayAllUsers']);



//    USER ROUTES 

Route::get('/add_user', function () {
    return View::make('console.add_user_form');
})->name('addUser');
Route::post('/console/addUser', [ConsoleController::class, 'createUser']);

Route::get('/edit_user', function () {
    return View::make('console.edit_user_form');
})->name('editUser');
Route::post('/console/editUser', [ConsoleController::class, 'editUser']);

Route::get('/delete_user', function () {
    return View::make('console.delete_user_form');
})->name('deleteUser');

Route::post('/console/delete_user', [ConsoleController::class, 'deleteUser']);





// Route::post('console/register', [ConsoleController::class, 'createUser']);



Route::post('/console/login', [ConsoleController::class, 'login']);
Route::post('page_edit/create_new/{returnTo}', [PageController::class, 'createPage'])->name('createPage');




//ARTICLES
// Route::get('/insert_update_article', function () {
//     return View::make('articles.editColumn');
// })->name('insertUpdateArticle');

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

Route::get('/insert_image_icons_2', function () {
    return View::make('images.partials.image_icons_2');
})->name('insertImageIcons2');

Route::get('/insert_upload_file', function () {
    return View::make('slides.partials.upload_file_bar');
})->name('insertUploadFile');

Route::get('/insert_file_select', function () {
    return View::make('slides.partials.select_file_bar');
})->name('insertFileSelect');

Route::get('/insert_slide_card', function () {
    return View::make('slides.partials.image_preview_card');
})->name('insertSlideCard');

Route::get('/insert_add_image_card', function () {
    return View::make('slides.partials.add_slide_card');
})->name('insertAddImageCard');

//TABS

//which is it??/
Route::get('/load_tab/no_tab_assigned', function () {
    return View::make('tabs.no_tab_assigned');
})->name('displayNoTabs');

Route::get('/no_tab_assigned', function () {
    View::make('tabs.no_tab_assigned');
})->name('noTabAssigned');
// two routes returning the same thing??  MIGHTBE NIETHER

Route::post('/quick_tab_asign', [TabController::class, 'quickAssign'])->name('QuickTabAssign');

Route::get('/edit_tabs', function () {
    return View::make('tabs.edit_tabs_form');
})->name('editTabs');

Route::post('/update_tabs', [TabController::class, 'updateTabs'])->name('update_tabs');

Route::get('/load_tab/{routeName}', [TabController::class, 'loadTabContent']);

//this should be renamed to tab/change_tracked
Route::post('/tab/new/{tabId}', function ($tabId) {
    Session::put('tabId', $tabId);
    return response()->json(['message' => $tabId . 'Session variable changed successfully']);
})->name('newTabId');

//SLIDES
Route::get('/dispay_slide_data', function () {
    return View::make('slides.forms.slide_data_form');
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

Route::get('/', function () {
    return View::make('app.opener');
})->name('opener');

Route::get('/session/{newLocation?}', function ($newLocation = null) {
    return view('app.session', ['newLocation' => $newLocation]);
})->name('sessionSet');

Route::get('/{page?}', function ($page = null) {
    return view('app.site', ['page' => $page]);
})->name('root');

Route::get('test_fetch/{action?}', function ($action = null) {
    return view('app.test_fetch', ['action' => $action]);
})->name('testFetch');

Route::get('/site2/site', function () {
    return View::make('app.site2');
})->name('site2');

Route::get('/insert_/insert_form/{sequence}', function ($sequence) {
    $sData = explode('^', $sequence);
    $formName = $sData[0];
    Session::put('scrollTo', 'rowInsert'.$sData[count($sData)-1]);
    if (strpos($formName, 'nav') !== false) {
        $htmlResponse = NavController::insert($formName);
        return $htmlResponse;
    }if (strpos($formName, 'img') !== false) {
        $imgFormName = $sData[0].'^'.$sData[1];
        $htmlResponse = ImageController::insert($imgFormName);
        return $htmlResponse;
    }if (strpos($formName, 'tab') !== false) {
        $htmlResponse = TabController::insert($formName);
        return $htmlResponse;
    }if (strpos($formName, 'article') !== false) {
        $htmlResponse = ArticleController::insert($formName);
        return $htmlResponse;
    }
    if (strpos($formName, 'page') !== false) {
        $htmlResponse = PageController::insert($formName);
        return $htmlResponse;
    } if (strpos($formName, 'footer') !== false) {
        $htmlResponse = PageController::insert($formName);
        return $htmlResponse;
    }
     else {
        return response()->json(['error' => 'Invalid form request'], 400);
    }
})->name('insertForm');

Route::get('/render_/render_content/{render}', function ($render) {

    if (strpos($render, 'nav') !== false) {
        $htmlResponse = NavController::render($render);
        return $htmlResponse;
    }
    elseif (strpos($render, 'page') !== false) {
        $htmlResponse = PageController::render($render);
        return $htmlResponse;
    }  elseif (strpos($render, 'tab') !== false) {
        $htmlResponse = TabController::render($render);
        return $htmlResponse;
    } elseif (strpos($render, 'img') !== false) {
        $htmlResponse = ImageController::render($render);
        return $htmlResponse;
    } elseif (strpos($render, 'article') !== false) {
        $htmlResponse = ArticleController::render($render);
        return $htmlResponse;
    } elseif (strpos($render, 'footer') !== false) {
        $htmlResponse = PageController::render($render);
        return $htmlResponse;
    }elseif (strpos($render, '联系我们') !== false) {
        $htmlResponse = ConsoleController::render($render);
        return $htmlResponse;
    }
    else {
      
       return response()->json(['error' => 'Invalid form request'], 400);
    }
})->name('render');

Route::post('session_var/{value}', function (Request $request) {
    $data = explode('^',  $request);
    if (strpos( $request, 'scroll') !== false) {
        Session::put('ScrollTo', $data[1]);
    }
});

Route::post('/write_/write_form', function (Request $request) {
    if (strpos($request->form_name, 'img') !== false) {
        $imageController = new ImageController();
        return $imageController->editImage($request);
    } elseif (strpos($request->form_name, 'nav') !== false) {
        $navController = new NavController();
        return $navController->write($request);
    } elseif (strpos($request->form_name, 'tab') !== false) {
        $tabController = new TabController();
        return $tabController->write($request);
    } elseif (strpos($request->form_name, 'page') !== false) {
        $pageController = new PageController();
        return $pageController->write($request);
    } elseif (strpos($request->form_name, 'article') !== false) {
        $articleCtl = new ArticleController();
        return $articleCtl->write($request);
    } elseif (strpos($request->form_name, 'slide') !== false) {
        $slideCtl = new SlideController();
        return $slideCtl->write($request);
    }
    elseif (strpos($request->form_name, 'logo') !== false) {
        $pageCtl = new PageController();
        return $pageCtl->write($request);
    }
    elseif (strpos($request->form_name, 'footer') !== false) {
        $pageCtl = new PageController();
        return $pageCtl->write($request);
    } elseif (strpos($request->form_name, 'contact') !== false) {
        $consoleCtl = new ConsoleController();
        return $consoleCtl->write($request);
    }elseif (strpos($request->form_name, 'thankyou') !== false) {
        $consoleCtl = new ConsoleController();
        return $consoleCtl->write($request);
    }else {}
})->name('write');
