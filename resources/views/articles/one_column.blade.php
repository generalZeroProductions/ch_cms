@php

    $articleId = 'article_' . $rowId;
@endphp
@if (!$tabContent)
    <div class = 'row row-contain'>
    @else
        <div class = "row tab-contain-one">
@endif
<div id = "{{ $articleId }}">
    @include('articles.partials.title_text', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $article,
        'info' => $info,
        'index' => $index,
    ])
</div>
</div>
