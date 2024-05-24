<?php

namespace App\Http\Controllers;

use App\Helpers\FootMaker;
use App\Helpers\PageMaker;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public static function insert($formName)
    {

        if ($formName === 'edit_title_page') {
            $htmlString = View::make('app.edit_mode.edit_title_page')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
        if ($formName === 'edit_footer_item') {
            $htmlString = View::make('footer.edit_foot_column')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);

        }
    }
    public function write(Request $request)
    {
Log::info($request);
        if ($request->form_name === 'edit_title_page') {
            $this->updatePageTitle($request);
        } elseif ($request->form_name === 'logo_edit') {
            $this->updateLogo($request);
        } elseif ($request->form_name === "edit_footer_item") {
            $this->updateFooter($request);
        } elseif ($request->form_name === "single_footer_form") {

            $site = Navigation::where('type', 'site')->first();
            $site->data = ['footer' => 'single'];
            $site->save();
        } elseif ($request->form_name === "double_footer_form") {

            $site = Navigation::where('type', 'site')->first();
            $site->data = ['footer' => 'double'];
            $site->save();
        }

    }

    public function updateFooter(Request $request)
    {

        $reqData = json_decode($request->data);
        $getparent = ContentItem::findOrFail($reqData[0]->id);

        $parent = $getparent->parent;

        foreach ($reqData as $sub) {
            if ($sub->record) {
                $record = ContentItem::findOrFail($sub->id);
                $record->index = $sub->index;
                $record->body = htmlspecialchars($sub->body);
                $record->save();
            } else {

                ContentItem::create([
                    'type' => 'footItem',
                    'body' => htmlspecialchars($sub->body),
                    'parent' => $parent,
                ]);
            }
        }

        if (isset($request->deleted)) {
            Log::info('DELETED ITMES ');
            $deleteData = json_decode($request->deleted);
            foreach ($deleteData as $delete) {
                if (isset($delete->record)) {
                    $remove = ContentItem::findOrFail($delete->id);
                    $remove->delete();
                }
            }
        }
        Log::info('FINISHED WRITEN GFOOTER ');

    }

    public function updateLogo(Request $request)
    {

        $logo = Navigation::where('type', 'logo')->first();
        $useTitle = '0';
        $useLogo = '0';
        if (isset($request->use_logo)) {
            $useLogo = '1';
        }
        if (isset($request->use_title)) {
            $useTitle = '1';
        }

        if ($request->hasFile('upload_file')) {
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
        Log::info('makeing foot request '. $render);
        $rData = explode('^', $render);
        if (isset($rData[1])) {
            if ($rData[1] === '联系我们') {
                $editMode = Session::get('editMode');
                $contact = ContentItem::where('type', 'contact')->first();
                $htmlString = View::make('console.contact', ['column' => $contact, 'editMode' => $editMode]);
                return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
            }
        }
        if ($rData[0] === 'page') {
            $page = ContentItem::where('type', 'page')->where('id', $rData[1])->first();
            $pageMaker = new PageMaker();
            $htmlString = $pageMaker->pageHTML($page, false, null);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }if ($rData[0] === 'footer') {
            Log::info('makeing foot request 2 ');
            $footMaker = new FootMaker();
            $htmlString = $footMaker->makeFooter();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
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
            'title' => $title,
        ]);
        Session::put('edit', true);
        Session::put('buildMode', true);
        Session::put('returnPage', $page->title);
        return redirect()->route('root', ['page' => $page->title]);
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

        $page = ContentItem::findOrFail($request->page_id);
        $rows = ContentItem::where('parent', $page->id)->get();
        foreach ($rows as $row) {
            $tabs = Navigation::where('parent', $row->id)->get();
            foreach ($tabs as $tab) {
                $tab->delete();
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
        if (Session::has('pageIndex')) {
            $pageIndex = Session::get('pageIndex');
            if ($pageIndex - 1 % 14 === 0) {
                $inqIndex -= 15;
                Session::put('inqIndex', $inqIndex);
            }
        }
        return redirect()->route('dashboard');
    }

    public function deleteRow(Request $request)
    {
        $rows = ContentItem::where('parent', $request->page_id)->orderBy('index')->get();
        $nextRowInsert = null;
        $row = ContentItem::findOrFail($request->row_id);
        foreach ($rows as $r) {
          
            if ($r->index > $row->index) {
                $r->index = $r->index - 1;
                $r->save();
                if (!isset($nextRowInsert)) {
                    $nextRowInsert = $r->id;
                }
            }
        }
        $tabs = Navigation::where('parent', $request->row_id)->get();
        foreach ($tabs as $tab) {
            $tab->delete();
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
