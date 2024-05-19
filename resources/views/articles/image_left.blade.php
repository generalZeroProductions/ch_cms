@php
use Illuminate\Support\Facades\Log;
    Log::info('@ imageLeft');
    $articleId = 'article_' . $rowId;
    $imageId = 'image_' . $rowId;
    
@endphp

<div class="row-contain">
    <div class = "row d-flex">
        <div class="col-3  align-items-start justify-content-end " id="{{$imageId}}">
            @include('articles.partials.image_column', [
                'pageId' => $pageId,
                'rowId' => $rowId,
                'column' => $column2,
            ])

        </div>
        <div class="col-9  align-items-start" id = "{{ $articleId }}">
            @include('articles.partials.title_text', [
                'pageId' => $pageId,
                'rowId' => $rowId,
                'column' => $column1,
                'info' => $info,
            ])
        </div>

    </div>

</div>
<style>
    .space-top-40 {
        background-color: orange;
        height: 40px;
    }

    .image-column {

        width: 100%;
    }
</style>
