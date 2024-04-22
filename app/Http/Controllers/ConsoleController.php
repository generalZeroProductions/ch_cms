<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function makeNewPage()
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
        return redirect()->route('root', ['pageName' => $title]);
    }
    public function updateSlideshow(Request $request)
    {
        dd($request);
    }
}
