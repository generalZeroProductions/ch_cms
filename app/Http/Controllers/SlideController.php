<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function createSlideshow(Request $request)
    {
        Session::put('scrollTo',$request->scroll_to);
        $firstSlide = ContentItem::create([
            'type' => 'column',
            'title'=>'slide 1 title',
            'image' => 'defaultSlide.jpg',
            'body' => 'slide 1 caption',
            'heading' => 'slide',
        ]);
        $slideIds = [$firstSlide->id];
        $rowData = [
            'slides' => $slideIds,
        ];
        $newRow = ContentItem::create([
            'title' => $request->page_name . '_' . $request->rowIndex,
            'index' => $request->row_index_slide+1,
            'type' => 'row',
            'heading' => 'slideshow',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);

        $pData = $page->data['rows'];
        
        foreach($pData as $data)
        {
            $row = ContentItem::findOrFail($data);
            if($row->index>$request->row_index_slide)
            {
                $row->index = $row->index + 1;
            }
            $row->save();
        }
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();

        return redirect()->route('root', ['newLocation' => $page->title]);
    }
    public function updateSlideshow(Request $request)
    {
        $slideData = json_decode($request->data);
        $slides = [];
        foreach ($slideData as $slide) {
            $newSlide = [
                'image' => $slide->image,
                'caption' => $slide->caption,
                'record' => $slide->record,
                'source' => $slide->source,
            ];
            $slides[] = $newSlide;
        }
        $slideIds = [];

        foreach ($slides as $slide) {
            if ($slide['record'] === null) {

                $newSlide = ContentItem::create([
                    'type' => 'column',
                    'image' => $slide['image'],
                    'body' => $slide['caption'],
                    'heading' => 'slide',
                ]);
                $slideIds[] = $newSlide->id;
            } else {
               
                $slideIds[] = $slide['record'];
                $oldSlide = ContentItem::find($slide['record']);
                $oldSlide->image = $slide['image'];
                $oldSlide->body = $slide['caption'];
                $oldSlide->save();
            }

        }
        $row = ContentItem::findOrFail($request->row_id);
        $removeUnused = [];
        foreach ($row->data['slides'] as $id) {
            if (!in_array($id, $slideIds)) {
                $removeUnused[] = $id;
            }
        }

        if (count($removeUnused) > 0) {
            foreach ($removeUnused as $id) {
                $item = ContentItem::findOrFail($id);
                $item->delete();
            }
        }

        $writeSlides = [
            'slides' => $slideIds,
        ];
        $row = ContentItem::findOrFail($request->row_id);
        $row->data = $writeSlides;
        $row->save();

        if ($request->files->count() > 0) {
            foreach ($request->files as $file) {
                $filename = $file->getClientOriginalName();
                Storage::putFileAs('public/images', $file, $filename);
            }
        }
        Session::put('scrollTo', $request->scroll_to);
        return redirect()->route('root', ['pageName' => $request->page_name]);
    }
}
