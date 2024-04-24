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
  
    $mobile = false;
    $editMode = false;
    session_start();
    if (isset($_SESSION['mobile'])) {
        $mobile = $_SESSION['mobile'];
    }
    if (isset($_SESSION['edit'])) {
        $editMode = $_SESSION['edit'];
    }
    $rowIndex = 0;
 
@endphp

@foreach ($allRows as $nextRow)
    @php
        $location['row'] = $nextRow;
    @endphp

    @if (isset($nextRow->heading) && $nextRow->heading === 'image_right')
   
        @include ('rows/image_right', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'two_column')
        @include ('rows/two_column', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'image_left')
        @include ('rows/image_left', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'one_column')
       
        @include ('rows/one_column', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'banner')
        @include ('rows/banner', [
            'location' => $location,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'tabs')

        @if ($mobile)
            @include ('rows/vert_tabs', [
                'location' => $location,
                'tabContent' => $tabContent,
            ])
        @else
            @include ('rows/tabs', [
                'location' => $location,
                'tabContent' => $tabContent,
            ])
        @endif
    @endif
@endforeach
