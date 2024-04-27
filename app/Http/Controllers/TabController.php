<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TabController extends Controller
{
    public function loadTabContent($routeName)
    {
        $page = ContentItem::where('title', $routeName)
            ->where('type', 'page')
            ->first();
        if ($page) {
            $location = [
                'page' => $page,
                'row' => null,
                'item' => null,
            ];
            return view('page', ['page' => $page, 'location' => $location, 'tabContent' => true]);
        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }
    public function updateTabs(Request $request)
    {
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
        return redirect()->route('root', ['newLocation' => $request->page_id . '_' . $request->scroll_to]);
    }
}
