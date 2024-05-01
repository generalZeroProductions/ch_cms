<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        Session::put('scrollTo',$request->scroll_to);
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
                $page = ContentItem::findOrFail($request->page_id);
                return redirect()->route('root', ['newLocation' => $page->title]);

            } else {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        return response()->json(['message' => 'No file uploaded'], 400);
    }
    public function useImage(Request $request)
    {
        Session::put('scrollTo',$request->scroll_to_select);
        $column = ContentItem::findOrFail($request->column_id_select);
        if ($column) {
            $column->image = $request->image_select;
            $column->save();
            $page = ContentItem::findOrFail($request->page_id_at_select);
            return redirect()->route('root', ['newLocation' => $page->title]);
        } else {
            return response()->json(['error' => 'Column not found'], 404);
        }
    }
    public function storeImage(Request $request)
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
                return redirect()->route('reroute', ['pageName' => $request->page_name.'_'.$request->scroll_to]);
            } else {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        return response()->json(['message' => 'No file uploaded'], 400);
    }
}
