<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function updateNavItem(Request $request)
    {
        // Retrieve the navigation item based on the ID from the request
        $navItem = Navigation::findOrFail($request->nav_id);

        // Update the title and route fields based on the values in the request
        $navItem->title = $request->nav_title;
        $navItem->route = $request->route;

        // Save the changes to the database
        $navItem->save();
        return redirect()->route('root',['pageName'=> $request->page_name]);
    }
    public function newNavItem(Request $request)
    {
        $highestIndexItem = Navigation::where('type', 'nav')
            ->orWhere('type', 'drop')
            ->orderBy('index', 'desc') // Use 'desc' to get the highest index
            ->first();

        $newIndex = $highestIndexItem ? $highestIndexItem->index + 1 : 1;
        $newNav = Navigation::create([
            'type' => 'nav',
            'index' => $newIndex,
            'title' => $request->nav_title,
            'route' => $request->route,
        ]);
        return redirect()->route('root',['pageName'=> $request->page_name]);
    }

    public function deleteItem(Request $request)
    {
        $request->validate([
            'nav_id' => 'required|numeric', // Validation rules for the id parameter
        ]);
        $item = Navigation::find($request->nav_id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $item->delete();
        return redirect()->route('root',['pageName'=> $request->page_name]);
    }

    public function updateDrop(Request $request)
    {
        $subData = json_decode($request->data);
        $removedItems = [];
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
        $dropNav = Navigation::find($request->drop_id);
        $dropNav->title = $request->drop_title;
        foreach ($allSubItems as $record) {
            $ids[] = $record->id;
        }
        $dData = $dropNav->data;
        $dData['items'] = $ids;
        $dropNav->data = $dData;
        $dropNav->save();

        foreach($removedItems as $record)
        {
            $record->delete();
        }
        return redirect()->route('root',['pageName'=> $request->page_name]);
    }

    public function addDropdown(Request $request)
    {
        $subData = json_decode($request->data);
        $allSubItems = [];
        foreach ($subData as $subItem) {
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
        usort($allSubItems, function ($a, $b) {
            return $a['index'] - $b['index'];
        });
        $ids = [];
        foreach ($allSubItems as $record) {
            $ids[] = $record->id;
        }
        $dataArray = ["items" => $ids]; // Associative array with key "items" and value $ids
        $dropNav = Navigation::create([
            'type' => 'drop',
            'title' => $request->drop_title,
            'data' => $dataArray,
        ]);
        return redirect()->route('root',['pageName'=> $request->page_name]);
    }
}
