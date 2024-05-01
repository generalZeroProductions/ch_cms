    @php
        use App\Models\ContentItem;
        $title = $column->title;
        $body = $column->body;
        $data = $column->data;
        $articleId = 'article_' . $column->id;
        $editMode = false;
        if(Session::has('edit'))
        {
            $editMode=Session::get('edit');
        }
    @endphp

    <div>
        @if ($editMode)
            <div class = "row">
                <a href="#" class="nav-link"
                    onClick=" loadEditArticle({{ $column }},'{{ json_encode($location) }}')">
                    <span class="menu-icon"><img src="{{ asset('icons/pen.svg') }}"></span>
                </a>
            </div>
        @endif
        <h3>{{ $title }}</h3>
        <p class = "indented-paragraph">{!! $body !!}</p>
        {{-- <p> {{ $body }}</p> --}}
    </div>
<style>

.indented-paragraph {
    text-indent: 20px; /* Adjust the value as needed */
}
</style>