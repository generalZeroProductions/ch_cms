@php
    use Illuminate\Support\Facades\Log;
    $tStyle = $column->styles['title'];
    $title = $column->title;
    $body = $column->body;
    $decodedBody = htmlspecialchars_decode($body);
    $escapedBody = addslashes($decodedBody);
    $divId = 'article_' . $column->id;
    $item = json_encode([
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $column,
        'body' => $escapedBody,
        'info' => $info,
    ]);

@endphp


<div id="{{ $divId }}">
    @if ($editMode && !$tabContent)
        <div class="d-flex align-items-center article-icon-space hide-editor">
            <a style= "cursor: pointer;"
                onClick = "insertForm('edit_text_article','{{ $item }}',  '{{ $divId }}')">
                <img src="{{ asset('icons/pen.svg') }}" class="article-pen-icon">
            </a>
        </div>
    @endif
    <div class={{ $tStyle }}> {{ $title }}</div>
    @php
        echo htmlspecialchars_decode($body);
    @endphp
    <br>
    @if ($column->styles['info'] === 'on')
        <br>
        <div style = "height:45px">
            @if ($info->styles['type'] === 'button')
                <button class="btn btn-outline-info" onClick="window.location='{{ $info->route }}'">
                    <{{ $column->styles['title'] }}> {{ $info->title }} </{{ $column->styles['title'] }}>
                </button>
            @else
                <a class='article-info-link' href="/{{ $info->route }}"> {{ $info->title }}</a>
            @endif
        </div>
    @endif
</div>
