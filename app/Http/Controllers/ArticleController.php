<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use Badcow\LoremIpsum\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Text;

class ArticleController extends Controller
{
    public function createTwoColumn(Request $request)
    {
        Session::put('scrollTo',$request->scroll_to);
        $generator = new Generator();
        $loremIpsumText = $generator->getParagraphs(1);
        $column = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText),
            'title' => 'first column title',
            'heading' => 'title_text',
        ]);

        $columnIds[] = $column->id;
        $loremIpsumText2 = $generator->getParagraphs(1);
        $column2 = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText2),
            'title' => 'second column title',
            'heading' => 'title_text',
        ]);
        $columnIds[] = $column2->id;
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index_2col + 1,
            'type' => 'row',
            'heading' => 'two_column',
            'data' => $rowData,
        ]);

        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach ($pData as $data) {
            $row = ContentItem::findOrFail($data);
            if ($row->index > $request->row_index_2col) {
                $row->index = $row->index + 1;
                $row->save();
            }
        }
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }
    public function createOneColumn(Request $request)
    {
        Session::put('scrollTo',$request->scroll_to);
        $generator = new Generator();
        $loremIpsumText = $generator->getParagraphs(1);
        $column = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText),
            'title' => 'new column title',
            'heading' => 'title_text',
        ]);
        $columnIds = [$column->id];
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index_1col + 1,
            'type' => 'row',
            'heading' => 'one_column',
            'data' => $rowData,
        ]);
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach ($pData as $data) {
            $row = ContentItem::findOrFail($data);
            if ($row->index > $request->row_index_1col) {
                $row->index = $row->index + 1;
                $row->save();
            }
            
        }

        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }

    
    public function createImageArticle(Request $request)
    {
        Session::put('scrollTo',$request->scroll_to);
        $image = ContentItem::create([
            'type' => 'column',
            'heading' => 'image',
            'body' => 'new image caption',
            'title' => 'new image title',
            'image' =>'defaultImage.jpg'
        ]);
        $columnIds = [];
        $generator = new Generator();
        $loremIpsumText = $generator->getParagraphs(1);
        $column = ContentItem::create([
            'type' => 'column',
            'body' => implode("\n\n", $loremIpsumText),
            'title' => 'new column title',
            'heading' => 'title_text',
        ]);
        
       
        $row_heading = "image_left";
        $rowIndex = null;
        $pageId = null;
        if($request->image_at==="right")
        {
            $row_heading = "image_right";
           
        } 
        $columnIds [] =$column->id;
        $columnIds [] =$image->id;
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index+1,
            'type' => 'row',
            'heading' => $row_heading,
            'data' => $rowData,
        ]);

        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach ($pData as $data) {
            $row = ContentItem::findOrFail($data);
            if ($row->index > $request->row_index_1col) {
                $row->index = $row->index + 1;
            }
            $row->save();
        }
        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();
        return redirect()->route('root', ['newLocation' => Session::get('location')]);
    }
    public function updateArticle(Request $request)
    {

        Session::put('scrollTo', $request->scroll_to);
        $article = ContentItem::findOrFail($request->article_id);
        $article->title = $request->title;
        $article->body = $request->body;
        $article->save();
        return redirect()->route('root', ['newLocation' =>Session::get('location')]);
    }
}
