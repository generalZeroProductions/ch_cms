<?php
namespace App\Helpers;

use App\Models\ContentItem;
use Illuminate\Support\Facades\View;

class PageMaker
{
    public function pageHTML($page, $tabContent)
    {
        $getters = new Getters();
        $setters = new Setters();
        $location = [
            'page' => $page,
        ];
        $mobile = $getters->getMobile();
        $editMode = $getters->getEdit();
        $backColor = 'white';
        $allRows = $setters->setAllRows($page);

        $htmlString = '<div class="d-flex flex-column bd-highlight mb-3" style="background-color:' . $backColor . ';">';
        if ($editMode && $tabContent) {
            $htmlString .= View::make('/editor/build_page_bar', ['location' => $location]);
            $htmlString .= '<br>';
        }
        if ($editMode && !$tabContent) {
            $htmlString .= View::make('/app/layouts/partials/page_title_edit', ['location' => $location]);
            if (count($allRows) === 0) {
                $htmlString .= View::make('app/layouts/partials/start_adding');
                $htmlString .= View::make('app.layouts.partials.add_row_button', ['location' => $location, 'index' => 0]);
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
                $htmlString .= View::make('/editor/delete_row_bar', ['location' => $location, 'index' => $row->index]);

            }

            if ($row->heading != 'slideshow') {

                if ($row->heading != 'tabs') {
                    $columnData = $location['row']['data']['columns'];
                    $column1 = ContentItem::findOrFail($columnData[0]);
                    $column2 = null;
                    if (isset($columnData[1])) {
                        $column2 = ContentItem::findOrFail($columnData[1]);
                    }
                    if ($row->heading === 'one_column') {

                        $htmlString .= View::make('app.layouts.one_column', [
                            'location' => $location,
                            'tabContent' => $tabContent,
                            'editMode' => $editMode,
                            'column' => $column1,
                            'rowId' => $row->id,
                        ])->render();

                    } elseif ($row->heading === 'two_column') {
                        $htmlString .= View::make('app.layouts.two_column', [
                            'location' => $location,
                            'tabContent' => $tabContent,
                            'editMode' => $editMode,
                            'column1' => $column1,
                            'column2' => $column2,
                            'rowId' => $row->id,
                        ])->render();
                    } elseif ($row->heading === 'image_right') {
                        $htmlString .= View::make('app.layouts.image_right', [
                            'location' => $location,
                            'tabContent' => $tabContent,
                            'editMode' => $editMode,
                            'column1' => $column1,
                            'column2' => $column2,
                            'rowId' => $row->id,
                        ])->render();

                    } elseif ($row->heading === 'image_left') {
                        $htmlString .= View::make('app.layouts.image_left', [
                            'location' => $location,
                            'tabContent' => $tabContent,
                            'editMode' => $editMode,
                            'column1' => $column1,
                            'column2' => $column2,
                            'rowId' => $row->id,
                        ])->render();

                    }
                } else {
                   
                    if ($tabContent) {
                       
                        $htmlString .= View::make('app.cant_display_tabs');
                    } else {
                        
                        $tabData = $row->data['tabs'];
                       
                        $tabs = $setters->tabsList($tabData);
                        $tab0 = $setters->tabZero($location, $tabs);
                        $allRoutes = $setters->setAllRoutes();
                        
                        if ($mobile) {
                            dd('moble');
                            $htmlString .= View::make('app/layouts/accordian', [
                                'location' => $location,
                                'editMode' => $editMode,
                                'tabs' => $tabs[0],
                                'contents' => $setters->setTabContents($tabs, $row, $mobile, $allRoutes),
                                'allRoutes' => $allRoutes,
                                'rowId' => $row->id,
                            ]);

                        } else {
                            $htmlString .= View::make('app/layouts/tabs', [
                                'location' => $location,
                                'editMode' => $editMode,
                                'tabs' => $tabs,
                                'tab0' => $tab0,
                                'rowId' => $row->id,
                                'contents' => $setters->setTabContents($tabs, $row, $mobile, $allRoutes),
                                'allRoutes' => $setters->setAllRoutes(),
                            ]);
                        }
                    }
                }
            } else {

                $slides = $setters->setSLideShow($location);

                $htmlString .= View::make('app/layouts/slideshow', [
                    'location' => $location,
                    'editMode' => $editMode,
                    'rowId' => $row->id,
                    'slideList' => $slides[0],
                    'slideJson' => $slides[1],
                ])->render();
            }

            if ($editMode && !$tabContent) {
                $htmlString .= View::make('/editor/add_row_bar', ['location' => $location, 'index' => $row->index]);
            }

            $htmlString .= '</div>';
            $htmlString .= '<div style="height:32px"></div>';
        }
        $htmlString .= '</div>'; // Close the wrapping div

        return $htmlString;

    }
}
