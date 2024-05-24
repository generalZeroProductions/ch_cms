@php

    $articleId = 'article_' . $rowId;
    $imageId = 'image_' . $rowId;

@endphp


@if (!$tabContent)
    <div class="row row-contain">
    @else
        <div class = "row tab-contain-right">
@endif


<div class="col-9 d-flex " id = "{{ $articleId }}">
    @include('articles.partials.title_text', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'column' => $column1,
        'info' => $info,
    ])
</div>
<div class="col-3 d-flex image-column" id = "{{ $imageId }}">
    @include('articles.partials.image_column', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'column' => $column2,
    ])

</div>
</div>
