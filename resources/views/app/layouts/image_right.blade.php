@php
    use App\Models\ContentItem;
    $columnData = $location['row']['data']['columns'];
    $column1 = ContentItem::findOrFail($columnData[0]);
    $column2 = ContentItem::findOrFail($columnData[1]);
    $articleId = 'article_' . $column1->id;
    $editMode = false;
    if (Auth::check()) {
        $editMode = Session::get('edit');
    }
@endphp
<div class = 'container-fluid'>
    @if ($editMode)
        @include('app/layouts/partials.delete_row_button', ['index' => $location['row']['index']])
    @endif
    <div class = 'container'>
        <div class = "row">
            <div class="col-md-8" id = "{{ $articleId }}">
                @include('app/layouts/partials/title_text', [
                    'column' => $column1,
                    'location' => $location,
                ])
            </div>
            <div class="col-md-4">
                @include('app/layouts/partials/image_column', [
                    'column' => $column2,
                    'location' => $location,
                ])
            </div>
        </div>

    </div>
    @if ($editMode)
        @include('app/layouts/partials/add_row_button', [
            'location' => $location,
            'index' => $location['row']['index'],
        ])
    @endif
</div>
