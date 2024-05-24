<?php

namespace App\Http\Controllers;

use App\Helpers\PageMaker;
use App\Helpers\Setters;
use App\Helpers\TabMaker;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class TabController extends Controller
{

    public static function insert($formName)
    {
        Log::info('in  make: ' . $formName);
        if ($formName === 'edit_tabs') {
            Log::info('in Edit tabs now make: ' . $formName);
            $htmlString = View::make('tabs.edit_tabs_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }

    }
    public function assignRoute(Request $request)
    {
        Log::info($request);
       
        $tab = Navigation::findOrFail($request->tab_id);
        $tab->route = $request->route;
        $tab->save();
        Log::info($tab->parent);
        Session::put('tabKey', $request->tab_id);
        Session::put('scrollTo', 'rowInsert'.$tab->parent);
    }
    public function write(Request $request)
    {
        if ($request->form_name === 'assignRoute') {
            $this->assignRoute($request);
        }
        if ($request->form_name === 'tab_quick') {
            $this->assignRoute($request);
        }

        if ($request->form_name === 'edit_tabs') {
            $this->updateTabs($request);
        }
    }

    public function createTabbed(Request $request)
    {
        $rows = ContentItem::where('parent', $request->page_id)->get();
        foreach ($rows as $row) {
            if ($row->index > $request->row_index) {
                $row->index = $row->index + 1;
                $row->save();
            }
        }

        $newRow = ContentItem::create([
            'index' => $request->row_index + 1,
            'type' => 'row',
            'heading' => 'tabs',
            'body'=>'菜单选项卡',
            'parent' => $request->page_id,
        ]);

        Navigation::create([
            'type' => 'tab',
            'title' => "tab_1",
            'index' => 0,
            'route' => 'no_tab_assigned',
            'parent' => $newRow->id,
        ]);
        Navigation::create([
            'type' => 'tab',
            'title' => "tab_2",
            'route' => 'no_tab_assigned',
            'index' => 1,
            'parent' => $newRow->id,
        ]);
        Navigation::create([
            'type' => 'tab',
            'title' => "tab_3",
            'route' => 'no_tab_assigned',
            'index' => 2,
            'parent' => $newRow->id,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $newRow->id);
        return redirect()->route('root', ['page' => $page->title]);
    }
    public function loadTabContent($tabRoute)
    {
        $page = ContentItem::where('title', $tabRoute)
            ->where('type', 'page')
            ->first();
        if ($page) {
            $location = [
                'page' => $page,
                'row' => null,
                'item' => null,
            ];
            return view('app.page_layout', ['page' => $page, 'location' => $location, 'tabContent' => true]);
        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }
    public function updateTabs(Request $request)
    {
        Log::info($request);
        $subData = json_decode($request->data);
        foreach ($subData as $tab) {
            if (isset($tab->id)) {
                $record = Navigation::findOrFail($tab->id);
                $record->title = $tab->title;
                $record->index = $tab->index;
                $record->route = $tab->route;
                $record->save();
            } else {
                Navigation::create([
                    'type' => 'tab',
                    'title' => $tab->title,
                    'route' => 'no_tab_assigned',
                    'parent' => $request->row_id,
                    'index' => $tab->index,
                ]);
            }
        }

        if (isset($request->deleted)) {
            $deleteData = json_decode($request->deleted);
            foreach ($deleteData as $delete) {

                if (isset($delete->id)) {
                    $remove = Navigation::findOrFail($delete->id);
                    $remove->delete();
                }
            }
        }
        Session::forget('scrollTo');

    }
    public static function render($render)
    {
        Log::info('tab render sequence ' . $render);
        $rData = explode('^', $render);
        if ($rData[0] === 'tab_menu') {
            $row = ContentItem::findOrFail($rData[1]);
            $page = ContentItem::findOrFail($rData[2]);
            $tabMaker = new TabMaker();
            $htmlString = $tabMaker->renderTabRow($page, $row, false);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
}
