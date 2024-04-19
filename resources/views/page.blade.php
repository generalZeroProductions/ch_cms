@php
    use App\Models\ContentItem;
    $data = $page->data;
    $rowData = $data['rows'];
    $allRows = [];

    foreach ($rowData as $row_id) {
        $nextRow = ContentItem::findOrFail($row_id);
        if ($nextRow) {
            $allRows[] = $nextRow;
        }
    }
@endphp

@foreach ($allRows as $nextRow)
    @if (isset($nextRow->heading) && $nextRow->heading === 'image_right')
        @include ('rows/image_right', ['row' => $nextRow, 'page' => $page])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'two_column')
        @include ('rows/two_column', ['row' => $nextRow, 'page' => $page])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'image_left')
        @include ('rows/image_left', ['row' => $nextRow, 'page' => $page])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'one_column')
        @include ('rows/one_column', ['row' => $nextRow, 'page' => $page])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'tabs')
        {{-- @include ('rows/tabs', ['row' => $nextRow, 'page' => $page]) --}}
        @include ('rows/vert_tabs', ['row' => $nextRow, 'page' => $page])
    @endif
@endforeach
