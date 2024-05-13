<?php
namespace App\Helpers;

use App\Models\ContentItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class TabMaker
{
    function renderTabRow($row)
    {
        $htmlString = '';
        $setters = new Setters();
        $tabData = $row->data['tabs'];

        $tabs = $setters->tabsList($tabData);
        $tab0 = $setters->tabZero($row->index, $tabs);
        $allRoutes = $setters->setAllRoutes();
        $mobile = Session::get('mobile');
        if ($mobile) {
            dd('moble');
            $htmlString .= View::make('tabs/accordian', [
                'editMode' => Session::get('editMode'),
                'tabs' => $tabs[0],
                'contents' => $setters->setTabContents($tabs, $row, $mobile, $allRoutes),
                'allRoutes' => $allRoutes,
                'rowId' => $row->id,
            ]);

        } else {
            $htmlString .= View::make('tabs/tabs', [
                'editMode' => Session::get('editMode'),
                'tabs' => $tabs,
                'tab0' => $tab0,
                'rowId' => $row->id,
                'contents' => $setters->setTabContents($tabs, $row, $mobile, $allRoutes),
                'allRoutes' => $setters->setAllRoutes(),
            ]);
        }
        return $htmlString;
    }
}