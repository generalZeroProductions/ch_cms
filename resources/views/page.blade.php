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
    $mobile = false;
    $editMode = false;
    session_start();
    if (isset($_SESSION['mobile'])){
        $mobile = $_SESSION['mobile'];
    }
    if (isset($_SESSION['edit'])){
        $editMode = $_SESSION['edit'];
    }
    
    
@endphp
@if ($editMode)
        <div class="row title_change_div">
            <div class="col-md-3" id = "{{ $page->title }}_{{ $page->id }}">
                <p class = "title_indicator"> 页面名称:</p>
                <p class = "title_reference">{{ $page->title }}</p>
                <a href="#"
                    onClick = "changePageTitle('{{ json_encode($page) }}','{{ $page->title }}_{{ $page->id }}')">
                    <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                </a>
            </div>
        </div>
@endif

@foreach ($allRows as $nextRow)
    @if (isset($nextRow->heading) && $nextRow->heading === 'image_right')
        @include ('rows/image_right', [
            'row' => $nextRow,
            'pageName' => $pageName,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'two_column')
        @include ('rows/two_column', [
            'row' => $nextRow,
            'pageName' => $pageName,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'image_left')
        @include ('rows/image_left', [
            'row' => $nextRow,
            'pageName' => $pageName,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'one_column')
        @include ('rows/one_column', [
            'row' => $nextRow,
            'pageName' => $pageName,
            'tabContent' => $tabContent,
        ])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'banner')
        @include ('rows/banner', ['row' => $nextRow, 'pageName' => $pageName, 'tabContent' => $tabContent])
    @endif
    @if (isset($nextRow->heading) && $nextRow->heading === 'tabs')
        @if ($mobile)
            @include ('rows/vert_tabs', [
                'row' => $nextRow,
                'pageName' => $pageName,
                'tabContent' => $tabContent,
            ])
        @else
            @include ('rows/tabs', [
                'row' => $nextRow,
                'pageName' => $pageName,
                'tabContent' => $tabContent,
            ])
        @endif
    @endif
@endforeach

  @if ($editMode)
    <hr>
    <div class="row title_change_div">
        <button class = "btn btn-warning" onClick = "openBaseModal('createRow', null, null, null)">创建行</button>
    </div>
@endif
