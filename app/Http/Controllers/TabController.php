<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TabController extends Controller
{
    public function quickAssign(Request $request)
    {
        $tab = Navigation::findOrFail($request->tab_id);
        $tab->route = $request->route;
        $tab->save();
        Session::put('scrollTo', $request->scroll_to);
        return redirect()->route('root', ['newLocation' => Session::get('location'), 'tabAt' => $tab->id]);

    }
    public function createTabbed(Request $request)
    {

        Session::put('scrollTo', $request->scroll_to);
        $tab1 = Navigation::create([
            'type' => 'tab',
            'title' => "tab_1",
            'index' => 1,
            'route' => 'no_tab_assigned',
        ]);
        $tab2 = Navigation::create([
            'type' => 'tab',
            'title' => "tab_2",
            'route' => 'no_tab_assigned',
            'index' => 2,
        ]);
        $tab3 = Navigation::create([
            'type' => 'tab',
            'title' => "tab_3",
            'route' => 'no_tab_assigned',
            'index' => 3,
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
        // $routeData = explode('?', $tabRoute);
        // $route = $routeData[0];
        // Session::put('scrollTo', $routeData[1]);
        // $tabId = $routeData[2];
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
        Session::put('scrollTo', $request->scroll_to);
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
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }
}
