@php
    $articleId1 = 'article_' . $column1->id;
    $articleId2 = 'article_' . $column2->id;
    $rowId = $location['page']['id'] . $location['row']['id'];
@endphp

@if ($editMode && !$tabContent)
    @include('app/layouts/partials.delete_row_button', ['index' => $location['row']['index']])
@endif


<div class = "container-fluid" id={{ $rowId }}>
   <div class = 'container'>
    <div class = 'row'>
        <div class="col-md-6" id = "{{ $articleId1 }}">
            @include('app.layouts.partials.title_text', ['column' => $column1, 'location' => $location])
        </div>
        <div class="col-md-6" id = "{{ $articleId2 }}">
            @include('app.layouts.partials.title_text', ['column' => $column2, 'location' => $location])
        </div>
    </div>
    </div>
</div>
</div>
@if ($editMode)
    @include('app.layouts.partials.add_row_button', [
        'location' => $location,
        'index' => $location['row']['index'],
    ])
@endif
<br>
