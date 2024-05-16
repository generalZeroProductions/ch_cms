@php
    $articleId1 = 'article_1' . $rowId;
    $articleId2 = 'article_2' . $rowId;
@endphp

<div class = 'container'>
    <div class = 'row'>
        <div class="col-md-6" id = "{{ $articleId1 }}">
            @include('articles.partials.title_text', [
                'pageId' => $pageId,
                'rowId' => $rowId,
                'column' => $column1,
                'info' => $info1,
                'index' => $index,
            ])
        </div>
        <div class="col-md-6" id = "{{ $articleId2 }}">
            @include('articles.partials.title_text', [
                'pageId' => $pageId,
                'rowId' => $rowId,
                'column' => $column2,
                'info' => $info2,
                'index' => $index,
            ])
        </div>
    </div>
</div>
