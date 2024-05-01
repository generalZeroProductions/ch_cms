<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InquiriesController extends Controller
{
    protected $fillable = [
        'type','name', 'body', 'contact'
    ];
}
