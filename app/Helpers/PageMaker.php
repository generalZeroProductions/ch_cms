<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PageMaker
{
    public function pageHTML($page, $tabContent)
    {
        if (!isset($page)) {
            Log::info('SHOULD be no page asigned');
            $htmlString .= View::make('app.app.no_page_for_route');
            return $htmlString;
        }
Log::info(' in page maker');
        $setters = new Setters();
        $editMode = Session::get('editMode');
        $backColor = 'white';
        if($tabContent)
        {
            $backColor = 'rgb(205, 207, 216)';
        }
        $allRows = $setters->setAllRows($page);
        $htmlString = '<div class="d-flex flex-column bd-highlight mb-3" style="background-color:' . $backColor . ';">';
        if ($editMode && $tabContent) {
            $htmlString .= View::make('/editor/build_page_bar', ['page' => $page]);
            $htmlString .= '<br>';
        }
        if ($editMode && !$tabContent) {
            $htmlString .= View::make('app.edit_mode.page_title_edit', ['page' => $page]);
            if (count($allRows) === 0) {
                $htmlString .= View::make('app.edit_mode.start_adding');
                $htmlString .= View::make('app.edit_mode.add_row_button', ['page' => $page, 'index' => 0]);
            }
        }
        foreach ($allRows as $row) {
            $location['row'] = $row;
            $rowMarkId = 'row_mark' . $row->id;
            $className = 'row_mark';
            if ($tabContent) {
                $rowMarkId = 'tab_mark' . $row->id;
                $className = 'tab_mark';
            }
            $htmlString .= '<div class=' . $className . 'id=' . $rowMarkId . '>';
            if ($editMode && !$tabContent) {
                $htmlString .= View::make('app.edit_mode.delete_row_bar', ['page'=>$page,'row' => $row]);
            }
            if ($row->heading != 'slideshow') {
                if ($row->heading != 'tabs') {
                    $articleMaker = new ArticleMaker();
                  $htmlString.=  $articleMaker->makeArticle($row, $tabContent);
                } else {

                    if ($tabContent) {
                        $htmlString .= View::make('app.cant_display_tabs');
                    } else {
                        $tabMaker = new TabMaker();
                        $htmlString .= $tabMaker->renderTabRow($row);
                    }
                }
            } else {
                $slides = $setters->setSLideShow($location);
                $htmlString .= View::make('app/layouts/slideshow', [
                    'editMode' => $editMode,
                    'rowId' => $row->id,
                    'slideList' => $slides[0],
                    'slideJson' => $slides[1],
                ])->render();
            }
            if ($editMode && !$tabContent) {
                $htmlString .= View::make('app.edit_mode.add_row_bar', ['page'=>$page,'row' => $row]);
            }
            $htmlString .= '</div>';
            $htmlString .= '<div style="height:32px"></div>';
        }
        $htmlString .= '</div>'; // Close the wrapping div

        return $htmlString;

    }

}
