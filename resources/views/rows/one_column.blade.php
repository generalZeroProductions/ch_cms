@php
    use App\Models\ContentItem;
    $columnData = $location['row']['data']['columns'];
    $column = ContentItem::findOrFail($columnData[0]);
    $articleId = 'article_' . $column->id;
    $editMode = true;
@endphp
<div class = "container">
    @if ($tabContent)
        <div class="row">
        @else
            <div class="row space-row">
    @endif
    <div class="col-md-12" id = "{{ $articleId }}">
        @include('rows/title_text', ['column' => $column, 'location' => $location])
    </div>
</div>
</div>
