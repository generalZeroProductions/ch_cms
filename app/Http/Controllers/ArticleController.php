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
        $rows = ContentItem::where('parent', $request->page_id)->get();
        foreach ($rows as $row) {
            if ($row->index > $request->row_index) {
                $row->index = $row->index + 1;
                $row->save();
            }
        }
        $newRow = ContentItem::create([
            'index' => $request->row_index + 1,
            'type' => 'row',
            'heading' => 'two_column',
            'body'=>'两栏文章',
            'parent' => $request->page_id,
        ]);
        $articleMaker = new ArticleMaker();
        $articleMaker->newTitleText($newRow->id,0);
        $articleMaker->newTitleText($newRow->id,1);

       
        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $newRow->id);
        return redirect()->route('root', ['page' => $page->title]);
    }

    public function createOneColumn(Request $request)
    {
        $rows = ContentItem::where('parent', $request->page_id)->get();
        foreach ($rows as $row) {
            if ($row->index > $request->row_index) {
                $row->index = $row->index + 1;
                $row->save();
            }
        }
        $newRow = ContentItem::create([
            'index' => $request->row_index + 1,
            'type' => 'row',
            'heading' => 'one_column',
            'body'=>'单栏文章',
            'parent' => $request->page_id,
        ]);
        $articleMaker = new ArticleMaker();
        $articleMaker->newTitleText($newRow->id,0);
       

        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $newRow->id);
        return redirect()->route('root', ['page' => $page->title]);
    }

    public function createImageArticle(Request $request)
    {
        $rows = ContentItem::where('parent', $request->page_id)->get();
        foreach ($rows as $row) {
            if ($row->index > $request->row_index) {
                $row->index = $row->index + 1;
                $row->save();
            }
        }
        $rowHeading = "image_left";
        $rowBodey = ' 文章 - 图片左';
        if ($request->image_at === "right") {
            $rowHeading = "image_right";
            $rowBodey='文章 - 图片右';
        }
        $newRow = ContentItem::create([
            'index' => $request->row_index + 1,
            'type' => 'row',
            'heading' =>  $rowHeading,
            'body'=> $rowBodey,
            'parent' => $request->page_id,
        ]);
        $styles = ["corners" => ''];
        ContentItem::create([
            'type' => 'column',
            'heading' => 'image',
            'index'=>'1',
            'body' => 'new image caption',
            'title' => 'new image title',
            'image' => 'defaultImage.jpg',
            'styles' => $styles,
            'parent'=>$newRow->id
        ]);
        $articleMaker = new ArticleMaker();
        $articleMaker->newTitleText($newRow->id,0);
        $page = ContentItem::findOrFail($request->page_id);
        Session::put('scrollTo', 'rowInsert' . $newRow->id);
        return redirect()->route('root', ['page' => $page->title]);
    }

    public function updateArticle(Request $request)
    {
        Log::info(' # artice updateer' . $request);
        $article = ContentItem::findOrFail($request->article_id);
        $article->title = $request->title;
        $article->body = htmlspecialchars($request->body);

        $useInfo = 'off';
        if (isset($request->use_info_checkbox)) {
            $useInfo = 'on';
        }
        $titleSize = 't' . $request->title_size;
        $article->styles = ['info' => $useInfo, 'title' => $titleSize];
        $article->save();
        $info = Navigation::where('parent',$article->id)->first();
        $linkType = $request->inlineRadioOptions;
        $info->styles = ['type' => $linkType];
        $info->route = $request->route;
        $info->title = $request->info_title;
        $info->save();
        Session::put('scrollTo', 'rowInsert' . $request->row_id);
    }
}
