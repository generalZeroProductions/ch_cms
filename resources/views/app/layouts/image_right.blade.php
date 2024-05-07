@php
    use App\Models\ContentItem;
    $columnData = $location['row']['data']['columns'];
    $column1 = ContentItem::findOrFail($columnData[0]);
    $column2 = ContentItem::findOrFail($columnData[1]);
    $articleId = 'article_' . $column1->id;
     $imageId = 'image_' . $column2->id;
    $editMode = false;
        if (Auth::check()) {
        $editMode = Session::get('edit');
        if ($tabContent) {
            $backColor = 'rgb(190,190,190)';
        }
    }
@endphp

@if (!$tabContent)
    @if (!$editMode)
        <div class="space-top-40"></div>
    @endif
@endif
@if ($editMode && !$tabContent)
    @include('app/layouts/partials.delete_row_button', ['index' => $location['row']['index']])
@endif

<div class="d-flex justify-content-start"> {{-- sets a row containing the row   --}}

    <div class="col-9 d-flex align-items-start article-column" id = "{{ $articleId }}">
        @include('app/layouts/partials/title_text', [
            'column' => $column1,
            'location' => $location,
        ])
    </div>
    <div class="col-3 d-flex align-items-start image-column" id = "{{ $imageId }}">
        @include('app/layouts/partials/image_column', [
            'column' => $column2,
            'location' => $location,
        ])

    </div>
</div>
@if ($editMode && !$tabContent)
    @include('app/layouts/partials/add_row_button', [
        'location' => $location,
        'index' => $location['row']['index'],
    ])
@endif
