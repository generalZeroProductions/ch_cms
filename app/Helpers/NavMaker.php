<?php
namespace App\Helpers;

use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class NavMaker
{
    public function navHTML($key)
    {
        $setters = new Setters();
        $drops = Navigation::where('type', 'drop') ->orderBy('index')->get();
        $dropData = [];
        foreach($drops as $nav)
        {
            $dropData[] = $setters-> setSubNavs($nav);
        }
       
        $navItems = Navigation::whereIn('type', ['nav', 'drop'])
            ->orderBy('index')
            ->get();
      
        $canDelete = true;
        if (count($navItems) === 1) {
            $canDelete = false;
        }
        $htmlString = View::make('nav.navigation', [
            'navItems'=> $navItems,
            'dropData'=>$dropData,
            'key'=>$key,
            'editMode'=> Session::get('editMode'),
            'canDelete'=>$canDelete,
            'buildMode'=>Session::get('buildMode'),
        ]);
        
        return $htmlString;
    }
}
