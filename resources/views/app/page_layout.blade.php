@php
    use Illuminate\Support\Facades\Session;
    use App\Models\Navigation;
    use App\Models\ContentItem;
    $rowData = $location['page']['data']['rows'];
    $editMode;
    $buildMode;
    $mobile;
    $allRows;
    $tabTrack;
    if (!isset($fromCtl)) {
        $editMode = getEditMode();
        $buildMode = getBuildMode();
        $mobile = getMobile();
        $allRows = allRows($rowData);
        $tabTrack = getTabTrack();
    } else {
        $allRows = $ctlRows;
        $buildMode = $ctlBuild;
        $editMode = $ctlEdit;
        $mobile = $ctlMobile;
        $tabTrack = $ctlTabTrack;
    }

    $backColor = 'white';
    if ($editMode && $tabContent) {
        $backColor = '#cecece';
    }
    $headSpace = 168;

    $rowIndex = 0;

    if (Auth::check()) {
        if ($editMode) {
            $headSpace = 196;
        }
        if ($tabContent) {
            $backColor = '#cecece';
        }

        if ($buildMode) {
            $headSpace = 91;
        }
    }

@endphp


<style>
    .nav-space {
        display: block;
        background-color: white;
    }
</style>


<div class=nav-space style='height:{{ $headSpace }}px'></div>


@if ($editMode)
    @include('/app/layouts/partials/page_title_edit', ['location' => $location])
    @if (count($allRows) === 0)
        @include('app/layouts/partials/start_adding')
    @endif

    @include('/app/layouts/partials/empty', ['location' => $location])



@endif

<div class="d-flex flex-column bd-highlight mb-3" style="background-color:{{ $backColor }};">

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
            @php
                $columnData = $location['row']['data']['columns'];
                $column1 = ContentItem::findOrFail($columnData[0]);
                $column2 = ContentItem::findOrFail($columnData[1]);
            @endphp
            @include ('app.layouts.two_column', [
                'location' => $location,
                'tabContent' => false,
                'column1' => $column1,
                'column2' => $column2,
                'editMode' => $editMode,
            ])
            <br>
            <br>
        @endif
        @if (isset($nextRow->heading) && $nextRow->heading === 'image_left')
            @include ('app/layouts/image_left', [
                'location' => $location,
                'tabContent' => false,
            ])
            <br>
            <br>
        @endif
        @if (isset($nextRow->heading) && $nextRow->heading === 'one_column')
            @php
                $columnData = $location['row']['data']['columns'];
                $column = ContentItem::findOrFail($columnData[0]);
            @endphp
            @include ('app/layouts/one_column', [
                'location' => $location,
                'tabContent' => false,
                'column' => $column,
                'editMode' => $editMode,
            ])
            <br>
            <br>
        @endif
        @if (isset($nextRow->heading) && $nextRow->heading === 'banner')
            @php
                $slideData = $location['row']['data']['slides'];
                $slideList = [];
                $slideJson = [];
                foreach ($slideData as $slideId) {
                    $slide = ContentItem::findOrFail($slideId);
                    $jSlide = [
                        'image' => $slide->image,
                        'caption' => $slide->body,
                        'record' => $slide->id,
                    ];
                    $slideJson[] = $jSlide;
                    $slideList[] = $slide;
                }
            @endphp
            @include ('app/layouts/slideshow', [
                'location' => $location,
                'tabContent' => false,
                'slideJson' => $slideJson,
                'slideList' => $slideList,
            ])
            <br>
            <br>
        @endif
        @if (isset($nextRow->heading) && $nextRow->heading === 'tabs')
            @if ($mobile)
                @include ('app/layouts/accordian', [
                    'location' => $location,
                    'tabContent' => false,
                    'tabTrack' => $tabTrack,
                    'mobile' => $mobile,
                ])
                <br>
                <br>
            @else
                @include ('app/layouts/tabs', [
                    'location' => $location,
                    'tabContent' => false,
                    'tabTrack' => $tabTrack,
                    'mobile' => $mobile,
                ])
                <br>
                <br>
            @endif
        @endif
    @endforeach

</div>
