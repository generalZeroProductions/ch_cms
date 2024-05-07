<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
// use App\Helpers\TabFuncs\sessionGetters; 
use Illuminate\Support\Facades\Storage;

class TabController extends Controller
{
    public function quickAssign(Request $request)
    {dd($request);
        $tab = Navigation::findOrFail($request->tab_id);
        $tab->route = $request->route;
        $tab->save();}
    public function sortWrite(Request $request)
    {

        if ($request->form_name === 'tab_quick') {
            $this->quickAssign($request);
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
        Session::put('scrollTo', $request->scroll_to);
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
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }
    public static function sortRefresh($refresh)
    {

        $refreshData = explode('^', $refresh);
        if ($refreshData[0] === 'tab_refresh') {

            $row = ContentItem::findOrFail($refreshData[1]);

            $rowData = $row->data['tabs'];
            $tab = null;

            foreach ($rowData as $id) {
                $checkTab = Navigation::findOrFail($id);
                if ($checkTab->index === intval($refreshData[2])) {
                    $tab = $checkTab;
                    break;
                }
            }
            $draw = new drawCalls();
            $htmlString = $draw->drawTab($tab, $row);

            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
}

class sessionGetters
{

    public function getEdit()
    {
        if (Session::has('editMode')) {
            return Session::get('editMode');
        }
        return false;
    }
    public function getMobile()
    {
        if (Session::has('mobile')) {
            return Session::get('mobile');
        }
        return false;
    }
    public function getBuild()
    {
        if (Session::has('buildMode')) {
            return Session::get('buildMode');
        }
        return false;
    }
    public function getTab()
    {
        if (Session::has('trackTab')) {
            return Session::get('trackTab');
        }
        return false;
    }
    function setAllRoutes()
    {
        $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
        $allRoutes = json_encode($getRoutes);
        $directory = 'public/images';
        $files = Storage::allFiles($directory);
        $allImages = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $allImages[] = pathinfo($file, PATHINFO_BASENAME);
            }
        }
        return $allRoutes;
    }
}
class tabPageHTML
{
    public function getHTML($page, $location)
    {
        $getters = new sessionGetters();
        $mobile = $getters->getMobile();
        $editMode = $getters->getEdit();
        $buildMode = $getters->getBuild();
        $trackTab = $getters->getTab();
        $backColor = 'white';
        $tabTrack = '';
        $allRows = [];
        $pData = $page->data['rows'];

        foreach ($pData as $rowId) {
            $row = ContentItem::findOrFail($rowId);
            $allRows[] = $row;
        }
        // usort($allRows, 'compareByIndex');

        $htmlString = '<div class="d-flex flex-column bd-highlight mb-3" style="background-color:' . $backColor . ';">';
        if ($editMode) {
            $htmlString .= View::make('/app/layouts/partials/build_tab', ['location' => $location]);
            $htmlString .= '<br>';
        }
        foreach ($allRows as $nextRow) {

            $location['row'] = $nextRow;

            if (isset($nextRow->heading) && $nextRow->heading === 'image_right') {
                $htmlString .= View::make('app.layouts.image_right', [
                    'location' => $location,
                    'tabContent' => true,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'two_column') {
                $columnData = $location['row']['data']['columns'];
                $column1 = ContentItem::findOrFail($columnData[0]);
                $column2 = ContentItem::findOrFail($columnData[1]);
                $htmlString .= View::make('app.layouts.two_column', [
                    'location' => $location,
                    'tabContent' => true,
                    'editMode' => $editMode,
                    'buildMode' => $buildMode,
                    'column1' => $column1,
                    'column2' => $column2,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'image_left') {
                $htmlString .= View::make('app.layouts.image_left', [
                    'location' => $location,
                    'tabContent' => true,
                ])->render();

            }

            if (isset($nextRow->heading) && $nextRow->heading === 'one_column') {
                $columnData = $location['row']['data']['columns'];
                $column = ContentItem::findOrFail($columnData[0]);
                $htmlString .= View::make('app.layouts.one_column', [
                    'location' => $location,
                    'tabContent' => true,
                    'editMode' => $editMode,
                    'buildMode' => $buildMode,
                    'column'=>$column
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'banner') {
                $htmlString .= View::make('app.layouts.slideshow', [
                    'location' => $location,
                    'tabContent' => true,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'tabs') {
                $htmlString .= View::make('app.cant_display_tabs', [
                    'location' => $location,
                    'tabContent' => true,
                    'tabId' => $tabTrack,
                    'mobile' => $mobile,
                ])->render();
            }
        }
        $htmlString .= '</div>'; // Close the wrapping div
        return $htmlString;
    }

}

class drawCalls
{
    public function sortByIndex($a, $b)
    {
        return $a['index'] - $b['index'];
    }

    public function drawTab($tab, $row)
    {
        $page = ContentItem::where('type', 'page')
            ->where('title', $tab->route)
            ->first();

        $location = [
            'page' => $page,
            'row' => $row,
            'item' => null,
            'scroll' => null,
        ];
        if ($tab->route === 'no_tab_assigned') {
            $getter = new sessionGetters();
            $allRoutes = $getter->setAllRoutes();
           
            return View::make('tabs.no_tab_assigned', [
                'location' => $location,
                'tabContent' => true,
                'tabId' => $tab->id,
                'tabTitle' => $tab->title,
                'rowId' => $row->id,
                'allRoutes'=>$allRoutes
            ]
            )->render();

        } else {
            $html = new tabPageHTML();
            return $html->getHTML($page, $location);
        }

    }
}
