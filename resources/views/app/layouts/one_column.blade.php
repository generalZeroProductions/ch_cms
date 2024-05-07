@php
    $articleId = 'article_' . $column->id;
    $rowId = $location['page']['id'].$location['row']['id'];
@endphp
<div class = 'container-fluid' id= {{$rowId}}>
    @if ($editMode && !$tabContent)
        @include('app/layouts/partials.delete_row_button', ['index' => $location['row']['index']])
    @endif
    <div class = 'container'>
        <div class = "row">
            <div class="col-md-12" id = "{{ $articleId }}">
                @include('app/layouts/partials/title_text', ['column' => $column, 'location' => $location])
            </div>

        </div>
    </div>
    @if ($editMode && !$tabContent)
    <br>
        @include('app.layouts.partials.add_row_button', [
            'location' => $location,
            'index' => $location['row']['index'],
        ])
    @endif
</div>
