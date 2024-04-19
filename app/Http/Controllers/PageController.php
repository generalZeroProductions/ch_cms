<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
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

    public function updateArticle(Request $request)
    {
        $article = ContentItem::findOrFail($request->article_id);
        $article->title = $request->title;
        $article->body = $request->body_text;
        $article->save();
        return redirect()->route('root')->with('pageId', $request->page_id);
    }
   
    public function upload(Request $request)
    {
  
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for an image file
        ]);

        // Store the uploaded file in the public/images directory
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');


            // Generate a unique filename to prevent collisions
            $filename = $uploadedFile->getClientOriginalName();

            // Store the file in the public/images directory
            $path = $uploadedFile->storeAs('images', $filename, 'public');

            // If the file was successfully stored, return the file path
            if ($path) {
                $column = ContentItem::findOrFail($request->column_id);
                $column->image = $filename;
                $column->save();
                return redirect()->route('root')->with('pageId', $request->page_id);
                
            } else {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }
    
}
