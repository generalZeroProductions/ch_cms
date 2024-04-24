<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use App\Models\ContentItem;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function updateNavItem(Request $request)
    {
        $navItem = Navigation::findOrFail($request->nav_id);
        $navItem->title = $request->nav_title;
        $navItem->route = $request->route;
        $navItem->save();
        $returnPage = ContentItem::findOrFail($request->page_id);
        $location = [
            'page'=>$returnPage,
            'row'=>null,
            'column'=>null
        ];
        return redirect()->route('root',['newLoction'=> $location]);
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
        $returnPage = ContentItem::findOrFail($request->page_id);
        $location = [
            'page'=>$returnPage,
            'row'=>null,
            'column'=>null
        ];
        return redirect()->route('root',['newLoction'=> $location]);
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
        if($item->type === 'drop')
        {
            foreach($item->data['items'] as $id)
            {
                $sub = Navigation::find($id);
                $sub->delete();
            }
        }
        $item->delete();


        $returnPage = ContentItem::findOrFail($request->page_id);
        $location = [
            'page'=>$returnPage,
            'row'=>null,
            'column'=>null
        ];
        return redirect()->route('root',['newLoction'=> $location]);
    }

    public function updateDrop(Request $request)
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
        $dropNav = Navigation::find($request->drop_id);
        $dropNav->title = $request->drop_title;
        foreach ($allSubItems as $record) {
            $subNavIds[] = $record->id;
        }
        
        foreach ($dropNav->data['items'] as $id) {
            if (!in_array($id,$subNavIds)) {
                if(!in_array($id,$unusedItems))
                {
                    $unusedItems[] = $id;
                }
            }
        }

        if(count($unusedItems) > 0) {
            foreach($unusedItems as $id){
                $item = Navigation::findOrFail($id);
                $item->delete();
            }
        }

        $dData = $dropNav->data;
        $dData['items'] = $subNavIds;
        $dropNav->data = $dData;
        $dropNav->save();

        $returnPage = ContentItem::findOrFail($request->page_id);
        $location = [
            'page'=>$returnPage,
            'row'=>null,
            'column'=>null
        ];
        return redirect()->route('root',['newLoction'=> $location]);
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
        $returnPage = ContentItem::findOrFail($request->page_id);
        $location = [
            'page'=>$returnPage,
            'row'=>null,
            'column'=>null
        ];
        return redirect()->route('root',['newLoction'=> $location]);
    }
}
