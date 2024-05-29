@php
    $articleId1 = 'article_1' . $rowId;
    $articleId2 = 'article_2' . $rowId;
    $spacing = 0;

    if ($index !== 1) {
        if ($article1['titleStyle'] === 't1') {
            $spacing = 50;
        } elseif ($article1['titleStyle'] === 't2') {
            $spacing = 40;
        } elseif ($article1['titleStyle'] === 't3') {
            $spacing = 30;
        } elseif ($article1['titleStyle'] === 't4') {
            $spacing = 20;
        } elseif ($article1['titleStyle'] === 't5') {
            $spacing = 10;
        }
    }
@endphp
<div style='height:{{ $spacing }}px'></div>
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
<div class="col-md-6" id = "{{ $articleId2 }}" style="text-align: justify">
    @include('articles.partials.title_text', [
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $article2,
        'info' => $info2,
        'index' => $index,
    ])
</div>
</div>
