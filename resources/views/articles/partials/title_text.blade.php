    @php
        use Illuminate\Support\Facades\Log;
        $tStyle = $column->styles['title'];
        $title = $column->title;
        $body = $column->body;
        $divId = 'article_' . $column->id;
        $item = json_encode(['pageId' => $pageId, 'rowId' => $rowId, 'article' => $column, 'info' => $info]);

    @endphp


    <div id="{{ $divId }}">
        @if ($editMode && !$tabContent)
            <div class="d-flex align-items-center article-icon-space">
                <a style= "cursor: pointer;"
                    onClick = "insertForm('edit_text_article','{{ $item }}',  '{{ $divId }}')">
                    <img src="{{ asset('icons/pen.svg') }}" class="article-pen-icon">
                </a>
            </div>
        @endif
        <div class={{ $tStyle }}> {{ $title }}</div>
        <div> {!! $body !!}</div>


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
