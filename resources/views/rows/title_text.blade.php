    @php
        use App\Models\ContentItem;
        $title = $column->title;
        $body = $column->body;
        $data = $column->data;   
        $articleId = "article_".$column->id;
        $editMode = true;

    @endphp

    <div>
        @if ($editMode)
            <div class = "row">
                <a href="#" class="nav-link" onClick=" loadEditArticle({{$column}},'{{json_encode($location)}}')">
                    <span class="menu-icon"><img src="{{ asset('icons/pen.svg') }}"></span>
                </a>
            </div>
        @endif
        <h3>{{ $title }}</h3>
        <p> {{ $body }}</p>
    </div>
