@php
    $articleId1 = 'article_1' . $rowId;
    $articleId2 = 'article_2' . $rowId;
@endphp
@if (!$tabContent)
    <div class = 'row row-contain'>
    @else
        <div class = 'row tab-contain'>
@endif
<div class="col-md-6" id = "{{ $articleId1 }}">

    @include('articles.partials.title_text', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $article1,
        'info' => $info1,
        'index' => $index,
    ])
</div>
<div class="col-md-6" id = "{{ $articleId2 }}">
    @include('articles.partials.title_text', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $article2,
        'info' => $info2,
        'index' => $index,
    ])
</div>
</div>
