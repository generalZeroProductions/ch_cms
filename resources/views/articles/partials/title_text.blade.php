@php

    $divId = 'article_' . $article['id'];
    $tStyle = $article['titleStyle'];
    $item = json_encode([
        'pageId' => $pageId,
        'rowId' => $rowId,
        'article' => $article,
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
    <div class={{ $tStyle }}>
        @php
            echo htmlspecialchars_decode($article['title']);
        @endphp
    </div>
    @php
        echo htmlspecialchars_decode($article['body']);
    @endphp
    <br>
    @if ($info['show'] === 'on')

        <br>
        <div style = "height:45px">
            @if ($info['type'] === 'button')
                <button class="btn btn-outline-info" onClick="window.location='{{ $info['route'] }}'">
                    <{{ $article['titleStyle'] }}>
                        @php
                            echo htmlspecialchars_decode($info['title']);
                        @endphp
                        </{{ $article['titleStyle'] }}>
                </button>
            @else
                <a class='article-info-link' href="/{{ $info['route'] }}"> {{ $info['title'] }}</a>
            @endif
        </div>
    @endif
</div>
