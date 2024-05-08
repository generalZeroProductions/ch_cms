<?php
namespace App\Helpers;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Helpers\TabFuncs; 
use Illuminate\Support\Facades\Storage;

class Getters
{
    public function getEdit()
    {
        if (Session::has('editMode')) {
            return Session::get('editMode');
        }
        return false;
    }
    public function getMobile()
    {
        if (Session::has('mobile')) {
            return Session::get('mobile');
        }
        return false;
    }
    public function getBuild()
    {
        if (Session::has('buildMode')) {
            return Session::get('buildMode');
        }
        return false;
    }
    public function getTab()
    {
        if (Session::has('trackTab')) {
            return Session::get('trackTab');
        }
        return false;
    }
  
}


