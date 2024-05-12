<?php

namespace App\Http\Controllers;

use App\Helpers\NavMaker;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class NavController extends Controller
{
    public static function insert($formName)
    {
        Log::info('nav insert calling: ' . $formName);
        if ($formName === 'edit_nav') {
            $htmlString = View::make('nav.forms.edit_standard_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'nav_delete') {
            $htmlString = View::make('nav.forms.delete_nav_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'add_nav') {
            $htmlString = View::make('nav.forms.add_nav_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } elseif ($formName === 'dropdown_editor_nav') {
            $htmlString = View::make('nav.forms.edit_dropdown_form')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }
    public function write(Request $request)
    {
        Log::info('At Write: ' . $request->form_name);
        if ($request->form_name === 'nav_delete') {
            $this->deleteNavItem($request);
        }
        if ($request->form_name === 'edit_nav') {
            $this->updateNavItem($request);
        }
        if ($request->form_name === 'dropdown_editor_nav') {
            $this->updateDropdown($request);
        }
        if ($request->form_name === 'add_standard_nav') {
            $this->addStandardNav($request);
        }
        if ($request->form_name === 'add_dropdown_nav') {

            $this->addDropdown($request);
        }
    }
    public static function render($render)
    {
        $data = explode('^', $render);
        if ($data[0] === 'navigation') {
            $navMake = new NavMaker();
            $htmlString = $navMake->navHTML($data[1]);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }

    private function updateNavItem(Request $request)
    {
        $navItem = Navigation::findOrFail($request->item_id);
        $navItem->title = $request->title;
        $navItem->route = $request->route;
        $navItem->save();
    }
    public function addStandardNav(Request $request)
    {
        Log::info("inside adder request key ". $request->key);
       
        $prevNav = Navigation::where('type', 'nav')
                     ->orWhere('type', 'drop')
                     ->where('index', $request->key)
                     ->first();
       if($prevNav)
       {
        Log::info('got a nav for index '. $request->key);
       }
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();
        $navCount = 0;
       
        if (!$otherNav->isEmpty()) {
            foreach ($otherNav as $nav) {
                if ($nav->index > $prevNav->index) {
                    $nav->index = $nav->index + 1;
                    $nav->save();
                }
                $navCount++;
            }
        }

        Navigation::create([
            'type' => 'nav',
            'index' => $request->key + 1,
            'title' => 'NewNav' . $navCount + 1,
            'route' => null,
        ]);

    }

    public function deleteNavItem(Request $request)
    {

        $request->validate([
            'item_id' => 'required|numeric', // Validation rules for the id parameter
        ]);
        $prevNav = Navigation::where('type', 'nav')
                     ->orWhere('type', 'drop')
                     ->where('index', $request->key)
                     ->first();
        Log::info("inside delete request key ". $request->key);
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();

        
        if (!$otherNav->isEmpty()) {
            foreach ($otherNav as $nav) {
                if ($nav->index > $prevNav->index) {
                    $nav->index = $nav->index - 1;
                    $nav->save();
                }
            }
        }
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

        $reqData = json_decode($request->data);
        $dropNav = Navigation::findOrFail($request->item_id);
        $subData = ["dropdown" => $dropNav->index];
        $unusedItems = [];
        $allSubItems = [];

        foreach ($reqData as $subItem) {
            $subThis = Navigation::find($subItem->id);
            if ($subThis) {
                if ($subItem->title != '') {
                    $subThis->title = $subItem->title;
                    $subThis->route = $subItem->route;
                    $subThis->index = $subItem->index;
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
                        'data' => $subData,
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
        $prevNav = Navigation::where('type', 'nav')
        ->orWhere('type', 'drop')
        ->where('index', $request->key)
        ->first();
        $otherNav = Navigation::whereIn('type', ['nav', 'drop'])->get();
        $navCount = 0;

        if (!$otherNav->isEmpty()) {
            foreach ($otherNav as $nav) {
                if ($nav->index > $prevNav->index) {
                    $nav->index = $nav->index + 1;
                    $nav->save();
                }
                $navCount++;
            }
        }

        $subData = ["dropdown" => $prevNav->index + 1];
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
                'title' => '子菜单' . $i,
                'route' => null,
                'data' => $subData,
            ]);
            $subItemIds[] = $newItem->id;

        }
        $dataArray = ["items" => $subItemIds];
        Navigation::create([
            'type' => 'drop',
            'index' => $request->key + 1,
            'title' => 'NewDrop' . $navCount + 1,
            'route' => null,
            'data' => $dataArray,
        ]);

    }
}
