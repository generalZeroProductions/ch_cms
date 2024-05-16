<?php

namespace App\Http\Controllers;

use App\Helpers\ArticleMaker;
use App\Models\ContentItem;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ArticleController extends Controller
{
    public static function insert($formName)
    {
        Log::info('in  make: ' . $formName);
        if ($formName === 'edit_text_article') {
            Log::info('in Edit title text: ' . $formName);
            $htmlString = View::make('articles.forms.edit_title_text')->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }

    }
    public function write(Request $request)
    {
        Log::info('iside of write');
        Log::info($request);
        if ($request->form_name === 'edit_text_article') {
            $this->updateArticle($request);
        }
    }
    public static function render($render)
    {
        Log::info('ARTICLE RENDER SEQUENCE ' . $render);
        $rData = explode('^', $render);
        if ($rData[0] === 'update_article') {
            $page = ContentItem::findOrFail($rData[1]);
            $row = ContentItem::findOrFail($rData[2]);
            $articleMaker = new ArticleMaker();
            $htmlString = $articleMaker->makeArticle($page, $row, false);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
    }
    public function createTwoColumn(Request $request)
    {
        $articleMaker = new ArticleMaker();
        $titleText = $articleMaker->newTitleText();

        $columnIds[] = $titleText->id;
        $titleText = $articleMaker->newTitleText();

        $columnIds[] = $titleText->id;
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
        Session::put('scrollTo', 'row_mark' . $newRow->index);
        return redirect()->route('root', ['page' => $page->title]);
    }
    public function createOneColumn(Request $request)
    {
        $articleMaker = new ArticleMaker();
        $titleText = $articleMaker->newTitleText();
        $columnIds = [$titleText->id];
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


        Session::put('scrollTo', 'row_mark' . $newRow->index);
        return redirect()->route('root', ['page' => $page->title]);
    }

    public function createImageArticle(Request $request)
    {
        $styles = ["corners" => ''];
        $image = ContentItem::create([
            'type' => 'column',
            'heading' => 'image',
            'body' => 'new image caption',
            'title' => 'new image title',
            'image' => 'defaultImage.jpg',
            'styles' => $styles,
        ]);
        $columnIds = [];
        $articleMaker = new ArticleMaker();
        $titleText = $articleMaker->newTitleText();

        $row_heading = "image_left";
        if ($request->image_at === "right") {
            $row_heading = "image_right";

        }
        $columnIds[] = $titleText->id;
        $columnIds[] = $image->id;
        $rowData = [
            'columns' => $columnIds,
        ];
        $newRow = ContentItem::create([
            'index' => $request->row_index + 1,
            'type' => 'row',
            'heading' => $row_heading,
            'data' => $rowData,
        ]);
       
        $page = ContentItem::findOrFail($request->page_id);
        $pData = $page->data['rows'];
        foreach ($pData as $data) {
            $row = ContentItem::findOrFail($data);
            if ($row->index > $request->row_index) {
                $row->index = $row->index + 1;
            }
            $row->save();
        }


        $pData[] = $newRow->id;
        $page->data = ["rows" => $pData];
        $page->save();

        Session::put('scrollTo', 'row_mark' . $newRow->index);
        return redirect()->route('root', ['page' => $page->title]);
    }
    public function updateArticle(Request $request)
    {
       Log::info(' # artice updateer');
        $article = ContentItem::findOrFail($request->article_id);
        $article->title = $request->title;
        $article->body = $request->body;

        $useInfo = 'off';
        if (isset($request->use_info_checkbox)) {
            $useInfo = 'on';
        }
        $titleSize = 't' . $request->title_size;
        $article->styles = ['info' => $useInfo, 'title' => $titleSize];
        $article->save();
        $info = Navigation::findOrFail($article->data['info'][0]);
        $linkType = $request->inlineRadioOptions;
        $info->styles = ['type' => $linkType];
        $info->route = $request->route;
        $info->title = $request->info_title;
        $info->save();
        Session::put('scrollTo', $request->scroll_to);
    }
}
