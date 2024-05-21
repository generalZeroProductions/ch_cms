<?php

namespace App\Http\Controllers;

use App\Helpers\FootMaker;
use App\Helpers\PageMaker;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public static function insert($formName)
    {
        Log::info('in  page control insert: ' . $formName);
        if ($formName === 'edit_title_page') {
            $htmlString = View::make('app.edit_mode.edit_title_page')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
        if($formName==='edit_footer_item'){
            $htmlString = View::make('app.edit_foot_column')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
       
        }
    }
    public function write(Request $request)
    {
        Log::info($request->page_id . 'iside of logo write');
        if ($request->form_name === 'edit_title_page') {
            $this->updatePageTitle($request);
        }
        elseif ($request->form_name === 'logo_edit') {
            $this->updateLogo($request);
        }
        elseif($request->form_name ==="edit_footer_item"){
            $this->updateFooter($request);
        }
        elseif($request->form_name === "single_footer_form"){
            Log::info('at write to single');
            $site = Navigation::where('type','site')->first();
            $site->data=['footer'=>'single'];
            $site->save();
        }
        elseif($request->form_name === "double_footer_form"){
            Log::info('at write to double');
            $site = Navigation::where('type','site')->first();
            $site->data=['footer'=>'double'];
            $site->save();
        }

    }

    public function updateFooter(Request $request)
    {
        Log::info('reached update footer');
        Log::info($request);
        $reqData = json_decode($request->data);
        $getparent = ContentItem::findOrFail($reqData[0]->id);
       
        $parent = $getparent->parent;
        
        foreach ($reqData as $sub) {
            if ($sub->record) {
                $record = ContentItem::findOrFail($sub->id);
                Log::info($record);
                $record->index = $sub->index;
                $record->body = htmlspecialchars($sub->body);
                $record->save();
            } 
            else {
               
                ContentItem::create([
                    'type' => 'footItem',
                    'body' =>  htmlspecialchars($sub->body),
                    'parent' => $parent,
                ]);
            }
        }
        Log::info('OK HERE');
        if (isset($request->deleted)) {
           
            $deleteData = json_decode($request->deleted);
            foreach ($deleteData as $delete) {
                if (isset($delete->record)) {
                    $remove = Navigation::findOrFail($delete->id);
                    $remove->delete();
                }
            }
        }
        
    }
    
    public function updateLogo(Request $request)
    {
        Log::info($request);
        $logo = Navigation::where('type', 'logo')->first();
        $useTitle = '0';
        $useLogo = '0';
        if (isset($request->use_logo)) {
            $useLogo = '1';
        }
        if (isset($request->use_title)) {
            $useTitle = '1';
        }
        Log::info($logo->title);
        if ($request->hasFile('upload_file')) {
            Log::info('HAD FILE UPLOAD');
            $uploadedFile = $request->file('upload_file');
            $path = $uploadedFile->storeAs('images', $request->image_name, 'public');
            if (!isset($path)) {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        $logo->route = $request->image_name;
        $logo->title = $request->title;
        $logo->data = ['title' => $useTitle, 'image' => $useLogo];
        $logo->save();

    }
    public static function render($render)
    {
        $rData = explode('^', $render);
        if ($rData[0] === 'page') {
            $page = ContentItem::where('type', 'page')->where('id', $rData[1])->first();
            $pageMaker = new PageMaker();
            $htmlString = $pageMaker->pageHTML($page, false, null);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }  if ($rData[0] === 'footer') {
            $footMaker = new FootMaker();
            $htmlString = $footMaker->makeFooter();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
    public function createPage($returnTo)
    {
        $allPages = ContentItem::where('type', 'page')->get();
        $pageCount = count($allPages);
        $title = 'New_Page_' . $pageCount;
       
        $page = ContentItem::create([
            'type' => 'page',
            'title' => $title
        ]);
        Session::put('edit', true);
        Session::put('buildMode', true);
        // if ($returnTo === 'dashboard') {
        //     return redirect()->route('root', ['page' => $page->title]);
        // }
        Session::put('returnPage',$page->title);
        return redirect()->route('root', ['page' =>$page->title]);
    }

    public function updatePageTitle(Request $request)
    {
        $page = ContentItem::findOrFail($request->page_id);
        if ($page) {
            $navItems = Navigation::where('route', $page->title)->get();
            foreach ($navItems as $nav) {
                $nav->route = $request->title;
                $nav->save();
            }
            $page->title = $request->title;
            $page->save();
        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function deletePage(Request $request)
    {
        Log::info('request');
        Log::info($request);
        $page = ContentItem::findOrFail($request->page_id);
        $rows = ContentItem::where('parent', $page->id)->get();
        foreach ($rows as $row) {

            foreach ($rows as $r) {
                $tabs = Navigation::where('parent',$row->id);
                foreach($tabs as $tab){
                    $tab->delete();
                }
            }
            $columns = ContentItem::where('parent', $row->id)->get();
    
            foreach ($columns as $col) {
                $navs = Navigation::where('parent', $col->id)->get();
                foreach ($navs as $nav) {
                    $nav->delete();
                }
                $col->delete();
            }
            $row->delete();
        }
        $page->delete();
        return redirect()->route('dashboard');
    }

    public function deleteRow(Request $request)
    {
        Log::info($request);
        $rows = ContentItem::where('parent', $request->page_id)->orderBy('index')->get();
        $nextRowInsert = null;
        $row = ContentItem::findOrFail($request->row_id);
        foreach ($rows as $r) {
            $tabs = Navigation::where('parent',$request->row_id);
            foreach($tabs as $tab){
                $tab->delete();
            }
            if ($r->index > $row->index) {
                $r->index = $r->index - 1;
                if (!isset($nextRowInsert)) {
                    $nextRowInsert = $r->id;
                }
            }
        }
       
        $columns = ContentItem::where('parent', $row->id)->get();

        foreach ($columns as $col) {
            $navs = Navigation::where('parent', $col->id)->get();
            foreach ($navs as $nav) {
                $nav->delete();
            }
            $col->delete();
        }
        $row->delete();
        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $nextRowInsert);
        return redirect()->route('root', ['page' => $page->title]);

    }

}
