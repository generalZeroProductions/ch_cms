<?php
namespace App\Helpers;

use App\Models\ContentItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PageMaker
{

    public function pageHTML($page, $tabContent, $tabRow)
    {
        Log::info('@ PageMaker');
        if (!isset($page)) {
            Log::info('SHOULD be no page asigned');
            $htmlString = View::make('app.no_page_for_route');
            return $htmlString;
        }
        $articleMaker = new ArticleMaker();
        $editMode = Session::get('editMode');
        $backColor = 'white';
        if ($tabContent) {
            $backColor = 'rgb(205, 207, 216)';
        }

        $allRows = ContentItem::where('parent', $page->id)
            ->orderBy('index')
            ->get();

        $htmlString = '<div class="  d-flex flex-column" style="background-color:' . $backColor . ';" id="mainPageDiv">';
        if ($editMode && $tabContent) {
            $htmlString .= View::make('app.edit_mode.build_page_bar', ['page' => $page,'row'=>$tabRow]);
            $htmlString .= '<br>';
        }
        if ($editMode && !$tabContent) {
            $htmlString .= View::make('app.edit_mode.page_title_edit', ['page' => $page]);
            if (count($allRows) === 0) {
                $htmlString .= View::make('app.edit_mode.start_adding');
                $htmlString .= View::make('app.edit_mode.add_row_bar', ['page' => $page, 'row' => null, 'index' => 0]);
            }
        }
        foreach ($allRows as $row) {
            $rowInsertId = 'rowInsert' . $row->id;
            $className = 'rowInsert';
            if ($tabContent) {
                $rowInsertId = 'tabInsert' . $row->id;
                $className = 'tab_mark';
            }
       
            $htmlString .= '<div id = "' . $rowInsertId . '" class = "' . $className . '">';
         
            if ($row->heading != 'slideshow') {
                if ($row->heading != 'tabs') {
                    $htmlString .= $articleMaker->makeArticle($page, $row, $tabContent);

                } else {

                    if ($tabContent) {
                        $htmlString .= View::make('app.cant_display_tabs');
                    } else {
                        $tabMaker = new TabMaker();
                        $htmlString .= $tabMaker->renderTabRow($page, $row, $tabContent);
                    }
                }
            } elseif ($row->heading === 'slideshow') {
                $htmlString .= $articleMaker->makeSlides($page, $row, $tabContent);
            }

            if (!$editMode) {
                $htmlString .= '<div style="height:32px"></div>';
            }
            $htmlString .= ' </div>';
        }
        $htmlString .= ' </div>';
        return $htmlString;
    }

}
