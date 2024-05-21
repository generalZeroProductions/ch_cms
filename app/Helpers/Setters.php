<?php
namespace App\Helpers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
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
        $rows = ContentItem::where('parent', $page->id)->get();
        $allRows = [];
        foreach ($rows as $row) {
            $allRows[] = $row;
        }
        usort($allRows, function($a, $b) {
            return $a->index - $b->index;
        });
        return ($allRows);
    }
    function setSlideshow($page, $row)
    {
        $slides = ContentItem::where('parent', $row->id)->get();
        $slideList = [];
        $slideJson = [];
        foreach ($slides as $slide) {
            $jSlide = [
                'image' => $slide->image,
                'caption' => $slide->body,
                'record' => $slide->id,
                'index'=>$slide->index
            ];
            $slideList[] = $slide;
            $slideJson[] = $jSlide;
        }
        return [$slideList, $slideJson];
    }
    function tabZero($rowIndex, $tabs)
    {
        if(Session::has('tabKey')){
            $tabId = Session::get('tabKey');
            Session::forget('tabKey');
            return Navigation::findOrFail($tabId);
        }
        return $tabs[0];
    }
    function setTabContents($tabs, $row, $mobile, $allRoutes)
    {
Log::info('@ tab content'.count($tabs));
        $maker = new PageMaker();
        $contents = [];
        foreach ($tabs as $tab) {

            $page = ContentItem::where('type', 'page')
                ->where('title', $tab->route)
                ->first();
            if (isset($page)) {
                Log::info('## Got PAGE');
                $content = $maker->pageHTML($page, true,$row);
                $contents[] = $content;
            } else {
                Log::info('## make no nab');
                $content = View::make('tabs.no_tab_assigned', [
                    'tabId' => $tab->id,
                    'tabTitle' => $tab->title,
                    'tabIndex' => $tab->index,
                    'rowId' => $row->id, 
                    'pageId'=> $row->parent,
                    'mobile' => Session::get('mobile'),
                    'allRoutes' => $allRoutes,
                ])->render();
                $contents[] = $content;
            }

        }
        return $contents;

    }

    function sortByIndex($a, $b)
    {
        return $a['index'] - $b['index'];
    }

}
