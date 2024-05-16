@php
    use Illuminate\Support\Facades\Log;

    $articleId = 'article_' . $column->id;
@endphp

<div class = 'container'>
    <div class = "row">
        <div class="col-md-12" id = "{{ $articleId }}">
            @include('articles.partials.title_text', [
                'pageId' => $pageId,
                'rowId' => $rowId,
                'column' => $column,
                'index'=>$index
            ])
        </div>
    </div>

</div>
