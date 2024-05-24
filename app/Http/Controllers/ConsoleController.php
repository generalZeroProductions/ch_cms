<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Inquiries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class ConsoleController extends Controller
{
 
    public function deleteContact(Request $request){
        $inq = Inquiries::findOrFail($request->inq_id);
        $inq->delete();
        $inqIndex = Session::get('inqIndex');
        if($inqIndex-1%9===0)
        {
            $inqIndex -= 10;
            Session::put('inqIndex',$inqIndex);
        }
       
        Session::put('scrollDash',$request->scrollDash);
        return back()->withInput()->with('scrollDash', $request->scrollDash);
    
    }
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

        $validatedData = $request->validate([
            'name' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        $user = new User();
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();
        auth()->login($user);
        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function displayAllPages($index)
    {
        Session::put('pageIndex',$index);
        $allRecords = ContentItem::where('type', 'page')->orderBy('created_at', 'desc')->get();
        $html = view('console.page_pagination_form', ['allRecords' => $allRecords,'recordsIndex'=>$index])->render();
        return response()->json(['html' => $html]);
    }
    public function displayAllInquiries($index)
    {
        Session::put('inqIndex',$index);
        $index = (int)$index; // Ensure $index is an integer
        $allRecords = Inquiries::orderBy('created_at')->get();
        $html = view('console.inquiries_paginate',[ 'allRecords'=>$allRecords, 'recordsIndex'=>$index])->render();
        return response()->json(['html' => $html]);
    }

    public static function render($render)
    {

        $rData = explode('^', $render);
        if ($rData[0] === '联系我们') {
            $thanks = ContentItem::where('type', 'thankyou')->first();
            $html = view('console.thankyou', ['thanks' => $thanks])->render();
            return new Response($html, 200, ['Content-Type' => 'text/html']);
        }

    }
    public function write(Request $request)
    {
         Log::info($request);

        if ($request->form_name === 'client_contact_form') {
            Inquiries::create([
                'name' => $request->name,
                'contact' => $request->contact_info,
                'body' => $request->body,
                'read' => false,
                'type' => $request->contact_type,
            ]);  
        } if ($request->form_name === 'update_contact_form') {
  
            $contact = ContentItem::where('type','contact')->first();
            $contact->title = $request->title;
            $contact->body = $request->body;
            $contact->data = [
                'name_head'=>$request->name,
                'name_warn'=>$request->name_warn,
                'contact_head'=>$request->contact,
                'contact_warn'=>$request->contact_warn,
                'message_head'=>$request->message,
                'message_warn'=>$request->message_warn,
                'contact_type_1'=>$request->type_1,
                'contact_type_2'=>$request->type_2,
                'contact_type_3'=>$request->type_3,
            ];
            $contact->styles= ['title'=>'t'.$request->size_select];
            $contact->save();
          
        }
        if ($request->form_name === 'update_thankyou_form') {
            $contact = ContentItem::where('type','thankyou')->first();
            $contact->title = $request->title;
            $contact->body = $request->body;
            $contact->styles= ['title'=>'t'.$request->size_select];
            $contact->save();
           
        }
        if (strpos($request->form_name, 'mark_contact_read_') !== false) {
            if (preg_match('/\d+$/', $request->form_name, $matches)) {
                $number = (int)$matches[0];
                $inq = Inquiries::findOrFail($number);
                $inq->read=true;
                $inq->save();
            }
        }
    }
}
 