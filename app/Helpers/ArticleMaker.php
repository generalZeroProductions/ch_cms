<?php
namespace App\Helpers;

use App\Models\ContentItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class ArticleMaker
{
    function makeArticle($row, $tabContent)
    {
       
        $htmlString = '';
        $columnData = $row->data['columns'];
        $column1 = ContentItem::findOrFail($columnData[0]);
        $column2 = null;
        if (isset($columnData[1])) {
            $column2 = ContentItem::findOrFail($columnData[1]);
        }
        if ($row->heading === 'one_column') {
            Log::info('at one column');
            $htmlString .= View::make('articles.one_column', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column' => $column1,
                'row' => $row,
            ])->render();

        } elseif ($row->heading === 'two_column') {
            $htmlString .= View::make('articles.two_column', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column1' => $column1,
                'column2' => $column2,
                'row' => $row,
            ])->render();
        } elseif ($row->heading === 'image_right') {
            $htmlString .= View::make('articles.image_right', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column1' => $column1,
                'column2' => $column2,
                'row' => $row,
            ])->render();

        } elseif ($row->heading === 'image_left') {
            $htmlString .= View::make('articles.image_left', [
                'tabContent' => $tabContent,
                'editMode' => Session::get('editMode'),
                'column1' => $column1,
                'column2' => $column2,
                'row' => $row,
            ])->render();
        }
        return $htmlString;
    }
}
