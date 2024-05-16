<?php

namespace App\Http\Controllers;

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
    }
    public function write(Request $request)
    {
        Log::info($request->page_id . 'iside of page write');
        if ($request->form_name === 'edit_title_page') {
            $this->updatePageTitle($request);
        }
    }
    public static function render($render)
    {
        $rData = explode('^', $render);
        if ($rData[0] === 'page') {
            $page = ContentItem::where('type', 'page')->where('id', $rData[1])->first();
            $pageMaker = new PageMaker();
            $htmlString = $pageMaker->pageHTML($page, false);
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
        $ids = [];
        $data = ["rows" => $ids];
        $page = ContentItem::create([
            'type' => 'page',
            'title' => $title,
            'data' => $data,
        ]);
        Session::put('edit', true);
        Session::put('buildMode', true);
        if ($returnTo === 'dashboard') {

            Session::put('location', $page->title);
            return redirect()->route('root', ['newLocation' => $page->title]);
        }
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }

    // public function loadPage($routeName)
    // {
    //     $page = ContentItem::where('title', $routeName)
    //         ->where('type', 'page')
    //         ->first();
    //     if ($page) {
    //         $location = [
    //             'page' => $page,
    //             'row' => null,
    //             'item' => null,
    //         ];
    //         return view('app.page_layout', ['page' => $page, 'location' => $location, 'tabContent' => false]);
    //     } else {
    //         return response()->json(['error' => 'Page not found'], 404);
    //     }
    // }

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

        $rows = $page->data['rows'];
        foreach ($rows as $rowId) {
            $row = ContentItem::findOrFail($rowId);
            $request = Request::create('/delete-route', 'POST', ['row_id' => $row->id]);
            $this->deleteRow($request);
            $row->delete();
        }
        $page->delete();
        return redirect()->route('dashboard');
    }

    public function deleteRow(Request $request)
    {
        $row = ContentItem::findOrFail($request->row_id);
        $columnIds = [];
        $tabs = false;
        if (strpos($row->heading, 'column') !== false || strpos($row->heading, 'image') !== false) {
            $columnIds = $row->data['columns'];
        } elseif ($row->heading === 'slidesshow') {
            $columnIds = $row->data['slides'];
        } else {
            $columnIds = $row->data['tabs'];
            $tabs = true;
        }

        foreach ($columnIds as $id) {
            $item;
            if (!$tabs) {
                $item = ContentItem::findOrFail($id);

            } else {
                $item = Navigation::findOrFail($id);
            }
            $item->delete();
        }
        $prevRowIndex = 0;

        if (isset($request->page_id)) {
            $page = ContentItem::findOrFail($request->page_id);
            $rowData = $page->data['rows'];
            foreach ($rowData as $id) {
                $r = ContentItem::findOrFail($id);
                if ($r) {
                    if ($r->index === $row->index - 1) {
                        $prevRowIndex = $r->index;
                    }
                    if ($r->index > $row->index) {
                        $r->index = $r->index - 1;
                    }

                }
            }
            $page->data = $this->removeRowFromData($page->data['rows'], $row->id);
            $page->save();
            $row->delete();
            Session::put('scrollTo', 'row_mark' . $prevRowIndex);
            return redirect()->route('root');
        }

    }
    public function removeRowFromData($rowData, $rowToRemove)
    {
        $data = [];
        foreach ($rowData as $id) {
            if ($id !== $rowToRemove) {
                $data[] = $id;
            }
        }
        return ['rows' => $data];
    }

}
