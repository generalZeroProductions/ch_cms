<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function loadPage($routeName)
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
            return view('page', ['page' => $page, 'location' => $location,'tabContent'=>false]);
        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }
    public function loadTabContent($routeName)
    {
        $page = ContentItem::where('title', $routeName)
            ->where('type', 'page')
            ->first();
        if ($page) {
            $location = [
                'page'=>$page,
                'row'=> null,
                'item'=> null,
            ];
            return view('page', ['page' => $page,'location'=>$location, 'tabContent'=>true]);
        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }
    // public function loadTabContent($routeName)
    // {
    //     $page = ContentItem::where('title', $routeName)
    //         ->where('type', 'page')
    //         ->first();
    //     if ($page) {
    //         return redirect()->route('root', ['newon'Locati => $page->id, 'tabContent' => true]);

    //     } else {
    //         return response()->json(['error' => 'Page not found'], 404);
    //     }
    // }

    public function useImage(Request $request)
    {
        $column = ContentItem::findOrFail($request->column_id_select);
        if ($column) {
            $column->image = $request->image_select;
            $column->save();
            $returnPage = ContentItem::findOrFail($request->page_id_at_select);
            return redirect()->route('root', ['newLocation' => $returnPage->id]);
        } else {
            return response()->json(['error' => 'Column not found'], 404);
        }

    }

    public function pageTitle(Request $request)
    {
        $page = ContentItem::findOrFail($request->page_id);
        if ($page) {
            $navItems = Navigation::where('route', $page->title)->get();
            foreach ($navItems as $nav) {
                $nav->route = $request->page_title;
                $nav->save();
            }
            $page->title = $request->page_title;
            $page->save();
            return redirect()->route('root', ['newLocation' => $page->id]);

        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function updateArticle(Request $request)
    {
     
        $article = ContentItem::findOrFail($request->article_id);
        $article->title = $request->title;
        $article->body = $request->body_text;
        $article->save();
        $returnPage = ContentItem::findOrFail($request->page_id);
        return redirect()->route('root', ['newLocation' => $returnPage]);
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

        $returnPage = ContentItem::findOrFail($request->page_id);
        return redirect()->route('root', ['newLocation' => $returnPage]);
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for an image file
        ]);
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('images', $filename, 'public');
            if ($path) {
                $column = ContentItem::findOrFail($request->column_id);
                $column->image = $filename;
                $column->save();
                $returnPage = ContentItem::findOrFail($request->page_id);
                return redirect()->route('root', ['newLocation' => $returnPage->id]);
               
            } else {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        return response()->json(['message' => 'No file uploaded'], 400);
    }
}
