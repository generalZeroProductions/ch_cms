<?php
namespace TabFuncs;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Helpers\TabFuncs; 
use Illuminate\Support\Facades\Storage;

class sessionGetters
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
    function setAllRoutes()
    {
        $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
        $allRoutes = json_encode($getRoutes);
        $directory = 'public/images';
        $files = Storage::allFiles($directory);
        $allImages = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $allImages[] = pathinfo($file, PATHINFO_BASENAME);
            }
        }
        return $allRoutes;
    }
}