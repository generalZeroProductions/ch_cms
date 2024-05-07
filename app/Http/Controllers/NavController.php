<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class NavController extends Controller
{
    public static function sortRead($formName)
    {
        if ($formName === 'nav_standard') {
            $htmlString = View::make('nav.edit_nav_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'nav_delete') {
            $htmlString = View::make('nav.confirm_delete_nav')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'nav_add') {
            $htmlString = View::make('nav.add_nav_select_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } 
        elseif ($formName === 'nav_dropdown') {
            $htmlString = View::make('nav.edit_dropdown_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } 
        else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
    public static function sortRefresh($refresh)
    {
        $refreshData = explode('^', $refresh);
        if ($refreshData[0] === 'nav_standard') {
            $nav = Navigation::findOrFail($refreshData[1]);
            $htmlString = View::make('nav.partials.nav_item_edit', ['nav' => $nav, 'key' => $refreshData[2], 'canDelete' => true])->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
        if ($refreshData[0] === 'nav_dropdown') {
            $nav = Navigation::findOrFail($refreshData[1]);
            $htmlString = View::make('nav.partials.nav_drop_edit_mode', ['nav' => $nav,'fromctl'=>true, 'key' =>$refreshData[2] , 'canDelete' => true])->render();
         
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
        else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
    public function sortWrite(Request $request)
    {
       
        if ($request->form_name === 'nav_standard') {
            $this->updateNavItem($request);
        }
        if ($request->form_name === 'dropdown_edit_form') {
            $this->updateDropdown($request);
        }
    }
    private function updateNavItem(Request $request)
    {
        $navItem = Navigation::findOrFail($request->item_id);
        $navItem->title = $request->title;
        $navItem->route = $request->route;
        $navItem->save();
    }
    public function newNavItem(Request $request)
    {
        Session::put('scrollTo', $request->scroll_to);
        $prevNav = Navigation::findOrFail($request->item_id);
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();
        foreach ($otherNav as $nav) {
            if ($nav->index > $prevNav->index) {
                $nav->index = $nav->index + 1;
                $nav->save();
            }
        }
        $newNav = Navigation::create([
            'type' => 'nav',
            'index' => $prevNav->index + 1,
            'title' => 'NewNav' . count($otherNav),
            'route' => '',
        ]);

        return redirect($request->location);
    }

    public function deleteNavItem(Request $request)
    {
        Session::put('scrollTo', $request->scroll_to);

        $request->validate([
            'item_id' => 'required|numeric', // Validation rules for the id parameter
        ]);
        $item = Navigation::find($request->item_id);
        if ($item->type === 'drop') {
            foreach ($item->data['items'] as $id) {
                $sub = Navigation::find($id);
                $sub->delete();
            }
        }
        $item->delete();

        return redirect($request->location);
    }

    public function updateDropdown(Request $request)
    {
        $subData = json_decode($request->data);
        $unusedItems = [];
        $allSubItems = [];
        foreach ($subData as $subItem) {
            $subThis = Navigation::find($subItem->id);
            if ($subThis) {
                if ($subItem->title != '') {
                    $subThis->title = $subItem->title;
                    $subThis->route = $subItem->route;
                    $subThis->save();
                    $allSubItems[] = $subThis;
                } else {
                    $unusedItems[] = $subThis->id;
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
        $subNavIds = [];
        $dropNav = Navigation::find($request->item_id);
        $dropNav->title = $request->title;
        foreach ($allSubItems as $record) {
            $subNavIds[] = $record->id;
        }

        foreach ($dropNav->data['items'] as $id) {
            if (!in_array($id, $subNavIds)) {
                if (!in_array($id, $unusedItems)) {
                    $unusedItems[] = $id;
                }
            }
        }

        if (count($unusedItems) > 0) {
            foreach ($unusedItems as $id) {
                $item = Navigation::findOrFail($id);
                $item->delete();
            }
        }

        $dData = $dropNav->data;
        $dData['items'] = $subNavIds;
        $dropNav->data = $dData;
        $dropNav->save();
    }

    public function addDropdown(Request $request)
    {
        Session::put('scrollTo', $request->scroll_to);
        $prevNav = Navigation::findOrFail($request->item_id);
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();
        foreach ($otherNav as $nav) {
            if ($nav->index > $prevNav->index) {
                $nav->index = $nav->index + 1;
                $nav->save();
            }
        }
      
        $subItemIds = [];
        for ($i = 1; $i < 4; $i++) {
            $newItem = Navigation::create([
                'type' => 'sub',
                'index' => $i,
                'title' => 'NewDrop_Sub' . $i,
                'route' => '',
            ]);
            $subItemIds[] = $newItem->id;

        }
        $dataArray = ["items" => $subItemIds];
        $newNav = Navigation::create([
            'type' => 'drop',
            'index' => $prevNav->index + 1,
            'title' => 'NewNav' . count($otherNav),
            'route' => '',
            'data' => $dataArray,
        ]);
        return redirect($request->location);
    }
}
