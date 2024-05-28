@php

    $articleId = 'article_' . $rowId;
    $imageId = 'image_' . $rowId;

@endphp


@if (!$tabContent)
    <div class="row row-contain">
    @else
        <div class = "row tab-contain-right">
@endif

<div class="col-md-9" id = "{{ $articleId }}">
     @include('articles.partials.title_text', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $article,
        'info' => $info,
        'index' => $index,
    ])
</div>
<div class="col-md-3" id = "{{ $imageId }}">
    @include('articles.partials.image_column', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'column' => $column2,
    ])

</div>
</div>


<div class = "imageSizingScript">
<script>
setImageColumsSize('none');
</script>
</div>