<?php
namespace App\Helpers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class TabMaker
{
    function renderTabRow($page,$row,$tabContent)
    {
        $htmlString = '';
        $setters = new Setters();
        $tabs = Navigation::where('parent',$row->id)->orderBy('index')->get();
        $editMode = Session::get('editMode');
       
        $tab0 = $setters->tabZero($row->index, $tabs);
        $allRoutes = $setters->setAllRoutes();
        $mobile = Session::get('mobile');
        if ($mobile) {
            $htmlString .= View::make('tabs/accordian', [
                'editMode' => Session::get('editMode'),
                'tabs' => $tabs,
                'contents' => $setters->setTabContents($tabs, $row, $mobile, $allRoutes),
                'allRoutes' => $allRoutes,
                'rowId' => $row->id,
                'pageId'=>$page->id
            ]);

        } else {
            if ($editMode && !$tabContent) {
                $htmlString .= View::make('app.edit_mode.delete_row_bar', ['page' => $page, 'row' => $row]);
            }
            $htmlString .= View::make('tabs/tabs', [
                'editMode' => Session::get('editMode'),
                'tabs' => $tabs,
                'tab0' => $tab0,
                'rowId' => $row->id,
                'pageId'=>$page->id,
                'contents' => $setters->setTabContents($tabs, $row, $mobile, $allRoutes),
                'allRoutes' => $setters->setAllRoutes(),
            ]);
        }
        if ($editMode && !$tabContent) {
            $htmlString .= View::make('app.edit_mode.add_row_bar', ['page' => $page, 'row' => $row]);
        }
     
        return $htmlString;
    }
}