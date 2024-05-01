<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function createPage($returnTo)
    {
        $allPages = ContentItem::where('type', 'page')->get();
        $pageCount = count($allPages);
        $title = 'New_Page_' . $pageCount;
        $ids = [];
        $data = ["rows" => $ids];
        $page = ContentItem::create([
            'type' => 'page',
            'title' => $title,
            'data' => $data,
        ]);
        Session::put('buildMode', true);
        if($returnTo==='dashboard')
        {
            return redirect()->route('root', ['newLocation' => $page->title]);
        }
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }

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
            return view('app.page_layout', ['page' => $page, 'location' => $location,'tabContent'=>false]);
        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function updatePageTitle(Request $request)
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
            Session::put('location',$page->title);
            return redirect()->route('root', ['newLocation' => Session::get('location')]);

        } else {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    
}
