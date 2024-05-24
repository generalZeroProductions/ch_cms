@php
    $articleId = 'article_' . $column->id;
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
        'column' => $column,
        'index' => $index,
    ])
</div>
</div>
