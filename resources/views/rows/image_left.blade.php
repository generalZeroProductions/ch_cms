@php
    use App\Models\ContentItem;
    $data = $row->data;
    $columnData = $data['columns'];
    $column1 = ContentItem::findOrFail($columnData[0]);
    $column2 = ContentItem::findOrFail($columnData[1]);
    $articleId = 'article_' . $column1->id;
    $editMode = true;
@endphp
<div class="row space-row">
    <div class="col-md-3">
        @if ($editMode)
            <div class = "row">
                <a href="#" class="nav-link"
                    onClick="openBaseModal('uploadImage',null, '{{ json_encode($column2) }}','{{ $page->id }}')">
                    <span class="menu-icon"><img src="{{ asset('icons/pen.svg') }}"></span>
                </a>
            </div>
        @endif
        <img src="{{ asset('images/' . $column2->image) }}" class="img-fluid">
    </div>
    <div class="col-md-9" id = "{{ $articleId }}">
        @include('rows/title_text', ['column' => $column1, 'page' => $page])
    </div>
</div>
