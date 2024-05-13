<?php

namespace App\Http\Controllers;

use App\Helpers\PageMaker;
use App\Helpers\Setters;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class TabController extends Controller
{

    public static function insert($formName)   {
        Log::info('in  make: '. $formName);
        if ($formName === 'edit_tabs') {
            Log::info('in Edit tabs now make: '. $formName);
            $htmlString = View::make('tabs.edit_tabs_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }

    }
    public function assignRoute(Request $request)
    {
        $tab = Navigation::findOrFail($request->tab_id);
        $tab->route = $request->route;
        $tab->save();
    }
    public function write(Request $request)
    {
        if ($request->form_name === 'assignRoute') {
            $this->assignRoute($request);
        }
        if ($request->form_name === 'edit_tabs') {
            $this->updateTabs($request);
        }
    }

    public function createTabbed(Request $request)
    {
        Session::put('scrollTo', $request->scroll_to);
        $tab1 = Navigation::create([
            'type' => 'tab',
            'title' => "tab_1",
            'index' => 0,
            'route' => 'no_tab_assigned',
        ]);
        $tab2 = Navigation::create([
            'type' => 'tab',
            'title' => "tab_2",
            'route' => 'no_tab_assigned',
            'index' => 1,
        ]);
        $tab3 = Navigation::create([
            'type' => 'tab',
            'title' => "tab_3",
            'route' => 'no_tab_assigned',
            'index' => 2,
        ]);
        $tabIds = [$tab1->id, $tab2->id, $tab3->id];
        $rowData = [
            'tabs' => $tabIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index_tab + 1,
            'type' => 'row',
            'heading' => 'tabs',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach ($pData as $data) {
            $row = ContentItem::findOrFail($data);
            if ($row->index > $request->row_index_1col) {
                $row->index = $row->index + 1;
                $row->save();
            }

        }
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => $page->title]);

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
        Log::info('eneted tab editor');
        Session::put('returnPage', '');
        $removedItems = [];
        $allSubItems = [];
        $subData = json_decode($request->data);
        foreach ($subData as $subItem) {
            $subThis = Navigation::find($subItem->id);
            if ($subThis) {
                if ($subItem->title != '') {
                    $subThis->title = $subItem->title;
                    $subThis->route = $subItem->route;
                    $subThis->save();
                    $allSubItems[] = $subThis;
                } else {
                    $removedItems[] = $subThis;
                }
            } else {
                if ($subItem->title != '') {
                    $newItem = Navigation::create([
                        'type' => 'sub',
                        'index' => $subItem->index,
                        'title' => $subItem->title,
                        'route' => $subItem->route,
                    ]);
                    $allSubItems[] = $newItem;
                }
            }
        }
        usort($allSubItems, function ($a, $b) {
            return $a['index'] - $b['index'];
        });
        $ids = [];
        $tabRow = ContentItem::find($request->row_id);

        foreach ($allSubItems as $record) {
            $ids[] = $record->id;
        }
        $dData = $tabRow->data;
        $dData['tabs'] = $ids;
        $tabRow->data = $dData;
        $tabRow->save();
        foreach ($removedItems as $record) {
            $record->delete();
        }
    }
    public static function render($render)
    {
        Log::info('tab render sequence ' . $render);
        $rData = explode('^', $render);
        if ($rData[0] === 'tab_refresh') {
            Log::info('index ' . $rData[2]);
            $tab = Navigation::findOrFail($rData[3]);
            Log::info('got tab ' . $tab->title . ' routes to ' . $tab->route);
            $page = ContentItem::where('title', $tab->route)->first();
            if (isset($page)) {
                Log::info('trying ' . $page->title);
                $pageMaker = new PageMaker();
                $htmlString = $pageMaker->pageHTML($page, true);
                return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
            } else {
                $row = ContentItem::find($rData[1]);
                $setter = new Setters();
                $htmlString = View::make('tabs.no_tab_assigned', [
                    'tabId' => $tab->id,
                    'tabIndex' => $rData[2],
                    'tabTitle' => $tab->title,
                    'rowId' => $row->id,
                    'mobile' => Session::get('mobile'),
                    'allRoutes' => $setter->setAllRoutes(),
                ])->render();
                return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
            }

        } 
        elseif($rData[0] === 'tab_menu'){
            $row = ContentItem::findOrFail($rData[1]);
            $tabData = $row->data['tabs'];
            $setter = new Setters();
            $tabs = $setter->tabsList($tabData);
            $htmlString = View::make('tabs.tab_menu',[
                'rowId'=>$rData[1],
                'tabs'=>$tabs,
                'divId'=>$rData[2],
            'editMode'=>true]);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
}
