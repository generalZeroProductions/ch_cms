<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{public function write(Request $request)
    {
    if ($request->form_name === 'change_slide_height') {
        $row = ContentItem::findOrFail($request->row_id);
        $row->styles = ['height' => $request->height];
        $row->save();
    }
}
    public function createSlideshow(Request $request)
    {
        $rows = ContentItem::where('parent', $request->page_id)->get();
        foreach ($rows as $row) {
            if ($row->index > $request->row_index) {
                $row->index = $row->index + 1;
                $row->save();
            }
        }
        $newRow = ContentItem::create([
            'index' => $request->row_index + 1,
            'type' => 'row',
            'heading' => 'slideshow',
            'body' => '幻灯片',
            'parent' => $request->page_id,
            'styles' => ['height' => '300'],
        ]);
        ContentItem::create([
            'type' => 'column',
            'title' => 'slide 1 title',
            'image' => 'defaultSlide.jpg',
            'body' => 'slide 1 caption',
            'heading' => 'slide',
            'parent' => $newRow->id,
            'index' => '0',
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $newRow->id);
        return redirect()->route('root', ['page' => $page->title]);
    }
    public function updateSlideshow(Request $request)
    {
        $slideData = json_decode($request->data);
        foreach ($slideData as $slide) {
            if (isset($slide->record)) {
                $record = ContentItem::findOrFail($slide->record);
                $record->index = $slide->index;
                $record->image = $slide->image;
                $record->body = $slide->caption;
                $record->save();
            } else {
                ContentItem::create([
                    'type' => 'slide',
                    'image' => $slide->image,
                    'body' => $slide->caption,
                    'heading' => 'slide',
                    'parent' => $request->row_id,
                ]);
            }
        }
        if (isset($request->deleted)) {
            $deleteData = json_decode($request->deleted);
            foreach ($deleteData as $delete) {
            
                if (isset($delete->record)) {
                    $remove = ContentItem::findOrFail($delete->record);
                    $remove->delete();
                }
            }
        }
        if ($request->files->count() > 0) {
            foreach ($request->files as $file) {
                $filename = $file->getClientOriginalName();
                Storage::putFileAs('public/images', $file, $filename);
            }
        }
        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $request->row_id);
        return redirect()->route('root', ['page' =>$page->title ]);
    }}
