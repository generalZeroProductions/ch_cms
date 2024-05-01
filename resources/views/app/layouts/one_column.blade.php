@php
    use App\Models\ContentItem;
    $columnData = $location['row']['data']['columns'];
    $column = ContentItem::findOrFail($columnData[0]);
    $articleId = 'article_' . $column->id;
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

            <div class="col-md-12" id = "{{ $articleId }}">
                @include('app/layouts/partials/title_text', ['column' => $column, 'location' => $location])
            </div>

        </div>
    </div>
    @if ($editMode)
        @include('app.layouts.partials.add_row_button', [
            'location' => $location,
            'index' => $location['row']['index'],
        ])
    @endif
</div>
