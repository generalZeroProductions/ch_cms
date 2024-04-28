<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentItem;
use Badcow\LoremIpsum\Generator;
class ArticleController extends Controller
{
    public function createTwoColumn(Request $request)
    {
       
        $generator = new Generator();
        $loremIpsumText = $generator->getParagraphs(1);
        $column = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText),
            'title' => 'first column title',
            'heading' => 'title_text',
        ]);
      
        $columnIds []= $column->id;
        $loremIpsumText2 = $generator->getParagraphs(1);
        $column2 = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText2),
            'title' => 'second column title',
            'heading' => 'title_text',
        ]);
        $columnIds [] =$column2->id;
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index_2col+1,
            'type' => 'row',
            'heading' => 'two_column',
            'data' => $rowData,
        ]);
     
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach($pData as $data)
        {
            $row = ContentItem::findOrFail($data);
            if($row->index>$request->row_index_2col)
            {
                $row->index = $row->index + 1;
            }
            $row->save();
        }
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => $page->title]);
    }
    public function createOneColumn(Request $request)
    {
        $generator = new Generator();
        $loremIpsumText = $generator->getParagraphs(1);
        $column = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText),
            'title' => 'new column title',
            'heading' => 'title_text'
        ]);
        $columnIds = [$column->id];
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index_1col+1,
            'type' => 'row',
            'heading' => 'one_column',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach($pData as $data)
        {
            $row = ContentItem::findOrFail($data);
            if($row->index>$request->row_index_1col)
            {
                $row->index = $row->index + 1;
            }
            $row->save();
        }
        $pData = $page->data['rows'];
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => $page->title]);
    }
    public function updateArticle(Request $request)
    {

        $article = ContentItem::findOrFail($request->article_id);
        $article->title = $request->title;
        $article->body = $request->body_text;
        $article->save();
        $returnPage = ContentItem::findOrFail($request->page_id);
        return redirect()->route('root', ['newLocation' => $returnPage]);
    }
}
