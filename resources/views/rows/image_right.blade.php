@php
    use App\Models\ContentItem;
    $columnData = $location['row']['data']['columns'];
    $column1 = ContentItem::findOrFail($columnData[0]);
    $column2 = ContentItem::findOrFail($columnData[1]);
    $articleId = 'article_' . $column1->id;
    $editMode = true;
@endphp

<div class = "container">
    @if ($tabContent)
        <div class="row">
        @else
            <div class="row space-row">
    @endif
    <div class="col-md-8" id = "{{ $articleId }}">
        @include('rows/title_text', ['column' => $column1, 'location' => $location])
    </div>
    <div class="col-md-4">
        @include('rows/image_column', ['column' => $column2, 'location' => $location])
    </div>
</div>

</div>

</div>
