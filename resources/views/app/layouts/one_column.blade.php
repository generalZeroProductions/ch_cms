@php
    $articleId = 'article_' . $column->id;
@endphp
<div class = 'container-fluid'>
    <div class = 'container'>
        <div class = "row">
            <div class="col-md-12" id = "{{ $articleId }}">
                @include('app/layouts/partials/title_text', ['column' => $column, 'location' => $location])
            </div>
        </div>
    </div>
</div>
