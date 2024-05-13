<?php
namespace App\Helpers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class Setters
{

    function setSubNavs($nav)
    {
        $subNavItems = [];
        $navData = $nav->data['items'];
        foreach ($navData as $itemId) {
            $nextItem = Navigation::findOrFail($itemId);
            if ($nextItem) {
                $subNavItems[] = $nextItem;
            }
        }
        usort($subNavItems, array($this, 'sortByIndex'));
        return $subNavItems;
    }
    
    function getRowIdFromData($data)
    {
        foreach ($data as $d) {
            $column = ContentItem::findOrFail($d);
            if ($column) {
                return true;
            }
        }
        return false;
    }
    function setAllRoutes()
    {
        $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
        $allRoutes = json_encode($getRoutes);
        return $allRoutes;
    }
    function setAllImages()
    {
        $directory = 'public/images';
        $files = Storage::allFiles($directory);
        $allImages = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $allImages[] = pathinfo($file, PATHINFO_BASENAME);
            }
        }
        return $allImages;
    }
    function setAllRows($page)
    {
        $pData = $page->data['rows'];
        $allRows = [];
        foreach ($pData as $rowId) {
            $row = ContentItem::findOrFail($rowId);
            $allRows[] = $row;
        }
        usort($allRows, array($this, 'sortByIndex'));
        return ($allRows);
    }
    function setSlideshow($location)
    {
        $slideData = $location['row']['data']['slides'];
        $slideList = [];
        $slideJson = [];
        foreach ($slideData as $slideId) {
            $slide = ContentItem::findOrFail($slideId);
            $jSlide = [
                'image' => $slide->image,
                'caption' => $slide->body,
                'record' => $slide->id,
            ];
            $slideList[] = $slide;
            $slideJson[] = $jSlide;
        }
        return [$slideList, $slideJson];
    }
    function tabZero($rowIndex, $tabs)
    {
        return $tabs[0];
        // $tabData = null;
        // if (Session::has('trackTab')) {
        //     $tabData = explode('?', Session::get('trackTab'));
        // }
        // if (isset($tabData[0])) {
          
        //     if ($tabData[0] === $rowIndex) {
        //         return Navigation::findOrFail($tabData[1]);
        //     }
        // }
      
    }
    function setTabContents($tabs, $rowId, $mobile, $allRoutes)
    {

        $maker = new PageMaker();
        $contents = [];
        foreach ($tabs as $tab) {

            $page = ContentItem::where('type', 'page')
                ->where('title', $tab->route)
                ->first();
            if (isset($page)) {
                $content = $maker->pageHTML($page, true);
                $contents[] = $content;
            } else {

                $content = View::make('tabs.no_tab_assigned', [
                    'tabId' => $tab->id,
                    'tabTitle' => $tab->title,
                    'tabIndex' => $tab->index,
                    'rowId' => $rowId,
                    'mobile' => Session::get('mobile'),
                    'allRoutes' => $allRoutes,
                ])->render();
            }

        }
        return $contents;

    }
    function tabsList($tabData)
    {

        $tabs = [];
        foreach ($tabData as $tabId) {
            $nextTab = Navigation::findOrFail($tabId);
            if ($nextTab) {
                $tabs[] = $nextTab;
            }
        }
        usort($tabs, array($this, 'sortByIndex'));

        return $tabs;
    }
    function sortByIndex($a, $b)
    {
        return $a['index'] - $b['index'];
    }

}
