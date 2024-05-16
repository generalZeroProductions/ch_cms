@php
    use Illuminate\Support\Facades\Log;
    Log::info('goot abe here no? ' . $column1->id);
    $articleId = 'article_' . $rowId;
    $imageId = 'image_' . $rowId;

@endphp

<div class="container">
    <div class = "row">
    <div class="col-9 d-flex align-items-start " id = "{{ $articleId }}">
        @include('articles.partials.title_text', [
            'pageId' => $pageId,
            'rowId' => $rowId,
            'column' => $column1,
            'info' => $info,
        ])
    </div>
    <div class="col-3 d-flex align-items-start image-column" id = "{{ $imageId }}">
        @include('articles.partials.image_column', [
            'pageId' => $pageId,
            'rowId' => $rowId,
            'column' => $column2,
        ])

    </div>
</div>
</div>

<style>


    .image-column {

        width: 100%;
    }

</style>
