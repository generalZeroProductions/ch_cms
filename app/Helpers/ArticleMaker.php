<?php
namespace App\Helpers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ArticleMaker
{
    function makeArticle($page, $row, $tabContent)
    {
        Log::info('@ article Maker');
        $editMode = Session::get("editMode");
        $htmlString = '';
        if ($editMode && !$tabContent) {
            $htmlString .= View::make('app.edit_mode.delete_row_bar', ['page' => $page, 'row' => $row]);
        }

        $columns = ContentItem::where('parent', $row->id)
            ->orderBy('index')
            ->get();

        $column1 = $columns[0];
        $info1 = Navigation::where('parent', $column1->id)
            ->orderBy('index')
            ->first();

        $info2 = null;
        $column2 = null;
        if (isset($columns[1])) {
            $column2 = $columns[1];
            if ($column2->heading === 'title_text') {
                $info2 = Navigation::where('parent', $column2->id)
                    ->orderBy('index')
                    ->first();
            }
        }
        if ($row->heading === 'one_column') {

            $htmlString .= View::make('articles.one_column', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column' => $column1,
                'rowId' => $row->id,
                'pageId' => $page->id,
                'info' => $info1,
                'index' => $row->index,
            ])->render();

        } elseif ($row->heading === 'two_column') {
            $htmlString .= View::make('articles.two_column', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column1' => $column1,
                'info1' => $info1,
                'info2' => $info2,
                'column2' => $column2,
                'rowId' => $row->id,
                'pageId' => $page->id,
                'index' => $row->index,
            ])->render();
        } elseif ($row->heading === 'image_right') {
            $htmlString .= View::make('articles.image_right', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column1' => $column1,
                'column2' => $column2,
                'info' => $info1,
                'rowId' => $row->id,
                'pageId' => $page->id,
                'index' => $row->index,
            ])->render();

        } elseif ($row->heading === 'image_left') {
            $htmlString .= View::make('articles.image_left', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column1' => $column1,
                'column2' => $column2,
                'info' => $info1,
                'rowId' => $row->id,
                'pageId' => $page->id,
                'index' => $row->index,
            ])->render();
        }
        if ($editMode && !$tabContent) {
            $htmlString .= View::make('app.edit_mode.add_row_bar', ['page' => $page, 'row' => $row]);
        }

        return $htmlString;
    }

    function makeSlides($page, $row, $tabContent)
    {

        $editMode = Session::get("editMode");
        $htmlString = '';
        if ($editMode && !$tabContent) {
        
            $htmlString .= View::make('app.edit_mode.delete_row_bar', ['page' => $page, 'row' => $row]);
        }
        $setters = new Setters();
        $slides = $setters->setSLideShow($page, $row);
        $htmlString .= View::make('slides/slideshow', [
            'editMode' => $editMode,
            'rowId' => $row->id,
            'pageId' => $page->id,
            'slideList' => $slides[0],
            'slideJson' => $slides[1],
            'slideHeight' => $row->styles['height'],
        ])->render();

        if ($editMode && !$tabContent) {
            $htmlString .= View::make('app.edit_mode.add_row_bar', ['page' => $page, 'row' => $row, 'slideHeight' => $row->styles['height'][0]]);
        }

        return $htmlString;
    }
    function newTitleText($rowId, $index)
    {
        $loremIpsumText = "Donec diam ac tempus taciti ipsum porta praesent diam quis id, dictumst facilisis semper metus id integer magna ac tristique mollis quam, laoreet conubia torquent fringilla leo scelerisque molestie a viverra. Vel molestie morbi phasellus facilisis curae velit mauris commodo,mi at vulputate libero porta nibh ante, elementum etiam donec volutpat dolor amet aenean. Varius ullamcorper cras taciti vulputate fermentum enim interdum faucibus cubilia fringilla libero nulla aliquam, aenean lobortis commodo nisi augue felis aenean conubia ac fusce magna cras.";
        $cStyle = ['info' => 'off', 'title' => 't3'];
        $column = ContentItem::create([
            'type' => 'column',
            'body' => $loremIpsumText,
            'title' => 'new column title',
            'heading' => 'title_text',
            'styles' => $cStyle,
            'parent'=>$rowId,
            'index'=>$index

        ]);
        $infoStyle = ['type' => 'button'];
         Navigation::create([
            'type' => 'info',
            'title' => '更多信息',
            'route' => '/',
            'styles' => $infoStyle,
            'parent'=>$column->id
        ]);

        return $column;
    }
}
