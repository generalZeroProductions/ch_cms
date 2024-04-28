<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


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

    public function displayAllPages()
    {
        $records = ContentItem::where('type', 'page')->paginate(15);
        $html = view('console.page_pagination_form', ['records' => $records])->render();
        return response()->json(['html' => $html]);
    }
   
    

   

    public function makeArticlaImageColumn(Request $request)
    {
        if($request->has('row_index_left'))
        {
            $d = 9;
        }
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
