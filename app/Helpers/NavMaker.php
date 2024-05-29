<?php
namespace App\Helpers;

use App\Models\Navigation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class NavMaker
{
    public function navHTML($pageName)
    {

        $drops = Navigation::where('type', 'drop')->orderBy('index')->get();
        $dropData = [];
        foreach ($drops as $nav) {
            $subNavs = Navigation::where('parent', $nav->id)
                ->orderBy('index')
                ->get();
            $dropData[] = $subNavs;
        }
        $navItems = Navigation::whereIn('type', ['nav', 'drop'])
            ->orderBy('index')
            ->get();
        $indexItem = Navigation::whereIn('type', ['nav', 'sub'])
            ->where('route', $pageName)
            ->first();
        if ($indexItem) {

            if ($indexItem->type === 'sub') {
                $dNav = Navigation::findOrFail($indexItem->parent);
                Session::put('navKey', $dNav->index);
            } else {
                Session::put('navKey', $indexItem->index);      
            }
        }
        $canDelete = true;
        if (count($navItems) === 1) {
            $canDelete = false;
        }

        $logo = Navigation::where('type', 'logo')->get()->first();
        $htmlString = View::make('nav.navigation', [
            'navItems' => $navItems,
            'dropData' => $dropData,
            'editMode' => Session::get('editMode'),
            'canDelete' => $canDelete,
            'buildMode' => Session::get('buildMode'),
            'logo' => $logo,

        ]);
        return $htmlString;
    }
}
