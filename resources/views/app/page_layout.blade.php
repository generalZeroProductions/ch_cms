@php
    use App\Models\ContentItem;
    $rowData = $location['page']['data']['rows'];

    $allRows = [];
    foreach ($rowData as $row_id) {
        $nextRow = ContentItem::findOrFail($row_id);
        if ($nextRow) {
            $allRows[] = $nextRow;
        }
    }
    function compareByIndex($a, $b)
    {
        return $a['index'] - $b['index'];
    }
    $editMode = true;
    $buildMode = false;
    if (Session::has('edit')) {
        $editMode = Session::get('edit');
    }
    if (Session::has('buildMode')) {
        $buildMode = Session::get('buildMode');
    }

    // Sort the array using the comparison function
    usort($allRows, 'compareByIndex');
    $rowIndex = 0;

@endphp
@if ($editMode && !$tabContent)

    @include('/app/layouts/partials/page_title_edit', ['location' => $location])
    @if(count($allRows)===0)
<p>开始向新页面添加行</p>
@endif
    @include('/app/layouts/partials/empty', ['location' => $location])
@endif

@foreach ($allRows as $nextRow)
    @php
        $location['row'] = $nextRow;
    @endphp

    @if (isset($nextRow->heading) && $nextRow->heading === 'image_right')
        @include ('app/layouts/image_right', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'two_column')
        @include ('app/layouts/rows/two_column', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'image_left')
        @include ('app/layouts/image_left', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'one_column')
        @include ('app/layouts/one_column', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'banner')
        @include ('app/layouts/slideshow', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'tabs')
        @if ($mobile)
            @include ('app/layouts//accordian', [
                'location' => $location,
                'tabContent' => $tabContent,
            ])
        @else
            @include ('app/layouts//tabs', [
                'location' => $location,
                'tabContent' => $tabContent,
            ])
        @endif
    @endif
@endforeach
@if ($buildMode)
<button>save page</button>
@endif