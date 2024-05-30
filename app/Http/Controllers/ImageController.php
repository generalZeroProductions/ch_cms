<?php

namespace App\Http\Controllers;

use App\Helpers\ArticleMaker;
use App\Models\ContentItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ImageController extends Controller
{
    public static function insert($formName)
    {
        $rData = explode('^', $formName);
        if ($rData[0] === 'img_edit') {
            $directory = 'public/images';
            $files = Storage::allFiles($directory);
            $column = ContentItem::findOrFail($rData[1]);
            $htmlString = View::make('images.image_edit', ['files' => $files, 'style' => $column->styles['corners']])->render();
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        } else {
            return response()->json(['error' => 'Invalid form name'], 400);
        }
    }

    public static function render($render)
    {
        $rData = explode('^', $render);
        if ($rData[0] === 'img_edit') {
            $articleMaker = new ArticleMaker;
            $page = ContentItem::findOrFail($rData[1]);
            $row = ContentItem::findOrFail($rData[2]);

            $htmlString = $articleMaker->makeArticle($page, $row, false);
            return new Response($htmlString, 200, ['Content-Type' => 'text/html']);
        }
    }

    public function editImage(Request $request)
    {
        if ($request->form_name === 'slide_img_upload') {

            $uploadedFile = $request->file('uploaded_image');
            if ($uploadedFile) {
                // Get the original name of the uploaded file
                $originalName = $uploadedFile->getClientOriginalName();
                $path = $uploadedFile->storeAs('images', $originalName, 'public');
                if (!isset($path)) {
                    return response()->json(['message' => 'Failed to upload file'], 500);
                }
            }

        } else {
            $column = ContentItem::findOrFail($request->column_id);
            $column->image = $request->image_name;
            $column->body = $request->caption;
            $column->styles = ["corners" => $request->corners];
            if ($request->hasFile('upload_file')) {
                $uploadedFile = $request->file('upload_file');
                $path = $uploadedFile->storeAs('images', $request->image_name, 'public');
                if (!isset($path)) {
                    return response()->json(['message' => 'Failed to upload file'], 500);
                }
            }
            $column->save();
            Session::put('scrollTo', 'rowInsert' . $request->row_id);
        }
    }
}
