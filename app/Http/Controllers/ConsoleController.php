<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConsoleController extends Controller
{
    public function login()
    {
     
        $attributes = request()->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt($attributes, $remember = false)) {
            return redirect('/dashboard');
        }
        // if (auth()->attempt($attributes)) {
           
        //     return redirect()->intended('/console/dashboard');
        // }
    
        // If authentication failed, return back with errors
        return back()->withInput()->withErrors(['password' => 'Invalid credentials']);
        
    }
    public function createUser(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create the new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        // Optionally, you can log in the new user immediately
        auth()->login($user);

        // Return a response indicating success or redirect to another page
        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function getPages()
    {
        // try {
        $records = ContentItem::where('type', 'page')->paginate(15);
        $html = view('console.pages_pagination', ['records' => $records])->render();
        return response()->json(['html' => $html]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
        // dd("route works");
        // $records = ContentItem::where('type', 'page')->paginate(15);
        // // Render the Blade view with records and return the HTML content
        // $html = view('console.pages_pagination', ['records' => $records])->render();

        // // Return the HTML content as a response
        // return response()->json(['html' => $html]);
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
                return redirect()->route('root', ['pageName' => $request->page_name]);
            } else {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
        return response()->json(['message' => 'No file uploaded'], 400);
    }
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

    public function createSlideshow(Request $request)
    {

        $firstSlide = ContentItem::create([
            'type' => 'column',
            'image' => 'defaultBanner.jpg',
            'body' => 'slide 1 caption',
            'heading' => 'slide',
        ]);
        $slideIds = [$firstSlide->id];
        $rowData = [
            'slides' => $slideIds,
        ];
        $newRow = ContentItem::create([
            'title' => $request->page_name . '_' . $request->rowIndex,
            'index' => $request->row_index,
            'type' => 'row',
            'heading' => 'banner',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => $request->page_id]);
    }

    public function createOneColumn(Request $request)
    {
        $column = ContentItem::create([
            'type' => 'column',
            'body' => 'new column body content here',
            'title' => 'new column title',
        ]);
        $columnIds = [$column->id];
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'title' => $request->page_name . '_' . $request->rowIndex,
            'index' => $request->row_index,
            'type' => 'row',
            'heading' => 'one_column',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => $request->page_id]);
    }
    public function createTwoColumn(Request $request)
    {
        $column = ContentItem::create([
            'type' => 'column',
            'body' => 'new column body content here',
            'title' => 'new column title',
            'heading' => 'title_text',
        ]);
        $columnIds = [$column->id];
        $column2 = ContentItem::create([
            'type' => 'column',
            'body' => 'new column body content here',
            'title' => 'new column title',
            'heading' => 'title_text',
        ]);
        $columnIds = [$column2->id];
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'title' => $request->page_name . '_' . $request->rowIndex,
            'index' => $request->row_index,
            'type' => 'row',
            'heading' => 'two_column',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => $request->page_id]);
    }
    public function makeArticlaImageColumn(Request $request)
    {
        $image = ContentItem::create([
            'type' => 'column',
            'heading' => 'image',
            'body' => 'new column body content here',
            'title' => 'new column title',
        ]);
        $columnIds = [$image->id];
        $column = ContentItem::create([
            'type' => 'column',
            'body' => 'new column body content here',
            'title' => 'new column title',
            'heading' => 'title_text',
        ]);
        $columnIds = [$column->id];
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'title' => $request->page_name . '_' . $request->rowIndex,
            'index' => $request->row_index,
            'type' => 'row',
            'heading' => 'one_column',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $page->data['rows'][] = $newRow->id;
        $page->save();
    }

}
