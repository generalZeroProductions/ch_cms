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
@include('app/layouts/partials/start_adding')
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
        @include ('app.layouts.two_column', [
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
@include('app/layouts/partials/save_page_button',['page' => $location['page']['id']])
@endif


<button type="button" class="btn btn-primary" onclick="openMainModal('modal-xl')">
  Open Main Modal (Width: 600px)
</button>

<!-- Main Modal -->
<div class="modal fade" id="main_modal" tabindex="-1" role="dialog" aria-labelledby="main_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" id ='main_modal_dialog'>
    <div class="modal-content" id= "main_modal_content">
      <!-- Modal Header -->
      <div class="modal-header" >
        <h5 class="modal-title" id="main_modal_label">Main Modal Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Modal Body -->
      <div class="modal-body" id = "main_modal_body">
        Main Modal Body
      </div>
      
      <!-- Modal Footer (Optional) -->
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>