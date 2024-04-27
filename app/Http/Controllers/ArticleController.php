<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentItem;

class ArticleController extends Controller
{
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
