@php

    $articleId = 'article_' . $rowId;
    $imageId = 'image_' . $rowId;
    $spacing = 0;

    if ($index !== 1) {
        if ($article['titleStyle'] === 't1') {
            $spacing = 50;
        } elseif ($article['titleStyle'] === 't2') {
            $spacing = 40;
        } elseif ($article['titleStyle'] === 't3') {
            $spacing = 30;
        } elseif ($article['titleStyle'] === 't4') {
            $spacing = 20;
        } elseif ($article['titleStyle'] === 't5') {
            $spacing = 10;
        }
    }
@endphp

<div style='height:{{ $spacing }}px'></div>
@if (!$tabContent)
    <div class="row row-contain">
    @else
        <div class = "row tab-contain-right">
@endif

<div class="col-md-9" id = "{{ $articleId }}" style="text-align: justify">
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
