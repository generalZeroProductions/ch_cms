<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function loadPage($routeName)
{
    $page = ContentItem::where('title', $routeName)
        ->where('type', 'page')
        ->first();

    if ($page) {
        // If found, return the page view
        return view('page', ['page' => $page]);
    } else {
        // If not found, return an error or handle it accordingly
        return response()->json(['error' => 'Page not found'], 404);
    }
}
}
