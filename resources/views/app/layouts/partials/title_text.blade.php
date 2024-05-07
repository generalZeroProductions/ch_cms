    @php
        use App\Models\ContentItem;
        $title = $column->title;
        $body = $column->body;
        $data = $column->data;
        $articleId = 'article_' . $column->id;
    @endphp
    <div>
        @if ($editMode && !$tabContent)
            <div class="d-flex align-items-center icon-space">
                <a href="#" onClick=" loadEditArticle({{ $column }},'{{ json_encode($location) }}')">
                    <span><img src="{{ asset('icons/pen.svg') }}" class="pen-icon"></span>
                </a>
            </div>
        @endif
        <div style="width:100%">
            <div> {!! $title !!}</div>

            <div> {!! $body !!}</div>

        </div>
    </div>



    <style>
        .pen-icon {
            margin-left: 10px;
            height: 18px
        }

        .icon-space {
            height: 48px;
        }
    </style>
