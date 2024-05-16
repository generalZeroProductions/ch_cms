<?php

namespace App\Http\Controllers;

use App\Helpers\Setters;
use App\Models\ContentItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Helpers\ArticleMaker;

class ImageController extends Controller
{
    public static function insert($formName)
    {
        $rData = explode('^', $formName);
        if ($rData[0] === 'img_edit') {
            $directory = 'public/images';
            $files = Storage::allFiles($directory);
            $column = ContentItem::findOrFail($rData[1]);
            $htmlString = View::make('images.image_edit', ['files' => $files, 'style'=>$column->styles['corners']])->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }

    public static function render($render)
    {
        $rData = explode('^', $render);
        if ($rData[0] === 'img_edit') {
            Log::info("in image render");
            $articleMaker = new ArticleMaker;
            $page = ContentItem::findOrFail($rData[1]);
            $row = ContentItem::findOrFail($rData[2]);
            
            $htmlString = $articleMaker->makeArticle($page,$row,false);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
    }
 

    public function editImage(Request $request)
    {
        $column = ContentItem::findOrFail($request->column_id);
        $column->image = $request->image_name;
        $column->body = $request->caption;
        $column->styles = ["corners" => $request->corners];
        $path = null;
        if ($request->hasFile('upload_file')) {
            Log::info('HAD FILE UPLOAD');
            $uploadedFile = $request->file('upload_file');
            $path = $uploadedFile->storeAs('images', $request->image_name, 'public');
            if (!isset($path)) {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        if ($path) {
            Log::info('SAVED');
        }
        $column->save();
        Session::put('scrollTo','rowInsert'.$request->row_id);
    }

    // public function storeImage(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for an image file
    //     ]);
    //     if ($request->hasFile('file')) {
    //         $uploadedFile = $request->file('file');
    //         $filename = $uploadedFile->getClientOriginalName();
    //         $path = $uploadedFile->storeAs('images', $filename, 'public');
    //         if ($path) {
    //             $column = ContentItem::findOrFail($request->column_id);
    //             $column->image = $filename;
    //             $column->save();
    //             return redirect()->route('reroute', ['pageName' => $request->page_name . '_' . $request->scroll_to]);
    //         } else {
    //             return response()->json(['message' => 'Failed to upload file'], 500);
    //         }
    //     }
    //     return response()->json(['message' => 'No file uploaded'], 400);
    // }
}
