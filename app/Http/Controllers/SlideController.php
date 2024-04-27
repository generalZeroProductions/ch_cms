<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
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
        return redirect()->route('root', ['pageName' => $request->page_name]);
    }
}
