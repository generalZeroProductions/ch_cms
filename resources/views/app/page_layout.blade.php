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
    $editMode = false;
    $buildMode = false;
    $mobile = false;
    if (Session::has('edit')) {
        $editMode = Session::get('edit');
    }
    if (Session::has('buildMode')) {
        $buildMode = Session::get('buildMode');
    }
    if (Session::has('mobile')) {
        $mobile = Session::get('mobile');
    }
//$tabTrack;
    //if (isset($tabAt)) {
    //    $tabTrack = $tabAt;
    //}

    // Sort the array using the comparison function
    usort($allRows, 'compareByIndex');
    $rowIndex = 0;
@endphp


@if (!$tabContent)
    @if (Auth::check())
        @if ($editMode)
            @if ($buildMode)
                <div class=under-build>
                </div>
            @else
                @if ($mobile)
                    <div class=under-edit-mobile>
                    </div>
                @else
                    <div class=under-edit>
                    </div>
                @endif
            @endif
            @if (count($allRows) === 0)
                @include('app/layouts/partials/start_adding')
            @endif
            @include('/app/layouts/partials/page_title_edit', ['location' => $location])
            @include('/app/layouts/partials/empty', ['location' => $location])
        @else
            <div class=under-auth></div>
        @endif
    @else
        <div class=under-nav></div>
    @endif
@else
    @if (Auth::check())
        @if ($editMode)
            @if (count($allRows) === 0)
                @include('app/layouts/partials/start_adding')
            @endif
            @include('/app/layouts/partials/page_title_edit_at_tab', ['location' => $location])
            @include('/app/layouts/partials/empty', ['location' => $location])
        @endif
    @endif
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
        @if ($tabContent)
            @include ('app.cant_display_tabs')
        @else
            @if ($mobile)
                @include ('app/layouts/accordian', [
                    'location' => $location,
                    'tabContent' => $tabContent,
                ])
            @else
                @include ('app/layouts/tabs', [
                    'location' => $location,
                    'tabContent' => $tabContent
                ])
            @endif
        @endif
    @endif
    <br> <br>
@endforeach
@if ($buildMode)
    @include('app/layouts/partials/save_page_button', ['page' => $location['page']['id']])
@endif


<!-- Main Modal -->
<div class="modal fade" id="main_modal" tabindex="-1" role="dialog" aria-labelledby="main_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" id ='main_modal_dialog'>
        <div class="modal-content" id= "main_modal_content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="main_modal_label">Main Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id ="close_main_modal">
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


<style>
    .under-edit {
        height: 179px;
        background-color: black;
    }

    .under-edit-mobile {
        height: 147px;
        background-color: black;
    }

    .under-nav {
        height: 58px;
        background-color: black;
    }

    .under-build {
        height: 100px;
        background-color: black;
    }

    .under-auth {
        height: 148px;
        background-color: black;
    }
</style>
