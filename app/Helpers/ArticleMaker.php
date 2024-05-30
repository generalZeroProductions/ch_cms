<?php
namespace App\Helpers;

use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\View;

class ArticleMaker
{
    function makeArticle($page, $row, $tabContent)
    {
        $setter = new Setters();
        $editMode = Session::get("editMode");
        $mobile = Session::get('mobile');
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

        $c1Info = ['id' => $info1->id,
            'show' => $column1->styles['info'],
            'type' => $info1->styles['type'],
            'title' => $setter->prepareString($info1->title),
            'route' => $info1->route];

        $article1 = ['id' => $column1->id,
            'title' => $setter->prepareString($column1->title),
            'titleStyle' => $column1->styles['title'],
            'body' => $setter->prepareString($column1->body)];

        $info2 = null;
        $article2 = null;
        if (isset($columns[1])) {
            $column2 = $columns[1];
            $info2 = Navigation::where('parent', $column2->id)
                ->orderBy('index')
                ->first();

            if ($column2->heading === 'title_text') {
                $c2Info = ['id' => $info2->id,
                    'show' => $column2->styles['info'],
                    'type' => $info2->styles['type'],
                    'title' => $setter->prepareString($info2->title),
                    'route' => $info2->route];
                $article2 = ['id' => $column2->id,
                    'title' => $setter->prepareString($column2->title),
                    'titleStyle' => $column2->styles['title'],
                    'body' => $setter->prepareString($column1->body)];
            }
        }
        if ($row->heading === 'one_column') {
            $htmlString .= View::make('articles.one_column', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'article' => $article1,
                'pageId' => $page->id,
                'rowId' => $row->id,
                'info' => $c1Info,
                'index' => $row->index,
            ])->render();
        } elseif ($row->heading === 'two_column') {
            $htmlString .= View::make('articles.two_column', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'pageId' => $page->id,
                'index' => $row->index,
                'article1' => $article1,
                'info1' => $c1Info,
                'article2' => $article2,
                'info2' => $c2Info,
                'rowId' => $row->id,
            ])->render();
        } elseif ($row->heading === 'image_right') {
            if ($mobile) {
                $htmlString .= View::make('articles.image_left', [
                    'tabContent' => $tabContent,
                    'editMode' => Session::get('editMode'),
                    'article' => $article1,
                    'column2' => $column2,
                    'info' => $c1Info,
                    'rowId' => $row->id,
                    'pageId' => $page->id,
                    'index' => $row->index,
                ])->render();
            } else {
                $htmlString .= View::make('articles.image_right', [
                    'tabContent' => $tabContent,
                    'editMode' => Session::get('editMode'),
                    'article' => $article1,
                    'column2' => $column2,
                    'info' => $c1Info,
                    'rowId' => $row->id,
                    'pageId' => $page->id,
                    'index' => $row->index,
                ])->render();
            }
        } elseif ($row->heading === 'image_left') {
            $htmlString .= View::make('articles.image_left', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'article' => $article1,
                'column2' => $column2,
                'info' => $c1Info,
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
            'tabContent' => $tabContent,
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
            'parent' => $rowId,
            'index' => $index,

        ]);
        $infoStyle = ['type' => 'button'];
        Navigation::create([
            'type' => 'info',
            'title' => '更多信息',
            'route' => '/',
            'styles' => $infoStyle,
            'parent' => $column->id,
        ]);

        return $column;
    }
}
