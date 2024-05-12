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


class ImageController extends Controller
{

    public static function insert($formName)
    {
        log::info($formName . 'at image insert');
        if ($formName === 'img_edit') {
            $directory = 'public/images';
            $files = Storage::allFiles($directory);
            $htmlString = View::make('images.image_edit', ['files' => $files])->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }

    public function uploadImage(Request $request)
    {
        Session::put('scrollTo', $request->scroll_to);
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

    public static function render($render)
    {
        $rData = explode('^', $render);
        if ($rData[0] === 'img_edit') {
            $setter = new Setters;
            // $directory = 'public/images';
            // $files = Storage::allFiles($directory);
            $column = ContentItem::findOrFail($rData[1]);
            $rowId = null;
            $rows = ContentItem::where('type', 'row')
                ->where(function ($query) {
                    $query->where('heading', 'image_left')
                        ->orWhere('heading', 'image_right');
                })
                ->get();
            foreach ($rows as $row) {
                $data = $row->data['columns'];
                $rowId = $setter->getRowIdFromData($data);
                if ($rowId) {
                    break;
                }

            }
            $htmlString = View::make('app.layouts.partials.image_column', ['rowId' => $rowId, 
            'column' => $column, 
            'editMode'=> Session::get('editMode'),
            'tabContent'=>Session::get('tabContent'),
            'mobile'=>Session::get('mobile')
        ]);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
    }
    public function useImage(Request $request)
    {
        Session::put('scrollTo', $request->scroll_to_select);
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

    public function editImage(Request $request)
    {
       
        $column = ContentItem::findOrFail($request->column_id);
        $column->image = $request->image_name;
        $column->body = $request->caption;
        Log::info('CORNERS? ' . $request->corners);
        $column->styles = ["corners" => $request->corners];
        $path = null;

        if ($request->hasFile('file')) {
            Log::info('HAD FILE UPLOAD');
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for an image file
            ]);
            $uploadedFile = $request->file('file');
            $filename = $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('images', $filename, 'public');
            if (!isset($path)) {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        } else {
            $path = 1;

        }
        if ($path) {
            $column->save();
            Log::info('SAVED');
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
                return redirect()->route('reroute', ['pageName' => $request->page_name . '_' . $request->scroll_to]);
            } else {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        return response()->json(['message' => 'No file uploaded'], 400);
    }
}
