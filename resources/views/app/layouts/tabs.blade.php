@php
    $tabData = $location['row']['data']['tabs'];
    $tabs = tabsList($tabData);
    $rowId = $location['row']['id'];
    $tabCol = 'tab_col_' . $rowId;
    $scrollTabs = 'scroll_' . $rowId;
$editMode = getEditMode();
    $tab0 = $tabs[0];
    $trackTab = getTabTrack();
    if (isset($tabTrack)) {
        $tabData = explode('?', $tabId); //  store this as pageIdrowIndex id and tabId ? tabId
        if (isset($tabData[0])) {
            $checkTab = $location['page']['id'] . $location['row']['index'];
            if ($tabData[0] === $checkTab) {
                $tab0 = findTab($tabData[1]);
            }
        }
    }
    $contentBoxId = 'content_'.$rowId;
    $tabContents = getTabContents($tabs, $rowId);
    $tab0Route = $tab0->route;
    $tabIndex = $tab0->index;
    $tagAnchor = "tab_".$tab0->index
@endphp

@if ($editMode && !$tabContent)
    @include('app/layouts/partials.delete_row_button', ['index' => $location['row']['index']])
@endif


<div class="d-flex justify-content-start" id="{{ $rowId }}">
    <div class="col-3" id = "{{ $tabCol }}">
        @if ($editMode)
            <div>
                <a href = "#"
                    onClick="editTabsList({{ json_encode($tabs) }},'{{ $rowId }}', '{{ json_encode($location) }}')">
                    <span><img src="{{ asset('icons/pen.svg') }}" class="pen-icon"></span>
                </a>
            </div>
        @endif
        <div id="{{ $scrollTabs }}">
            <ul id="tabs">
                @foreach ($tabs as $tab)
                  @php
                        $anchorId = "tab_".$tab->index;
                    @endphp
                    <li class =  "{{ $loop->first ? 'active' : '' }} no_dots" >
                        <a href="#" id = "{{$anchorId}}" class = "tab-body-on"
                            onClick= "changeTab('{{ $rowId }}','{{ $anchorId }}', '{{ $loop->index }}')">
                            {{ $tab->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-9 ">
            <div id="{{ $contentBoxId }}" class="tabContent_{{ $rowId }}">
            </div>
    </div>
</div>

<script>
    changeTab('{{ $rowId }}', '{{$tagAnchor }}', '{{ $tabIndex }}');
</script>

<style>
.no_dots{
     list-style: none;
}
   

    .tab-item-on {
        font-size: 30px;
        font-weight: 600;
        text-decoration: none;
        color: black;
    }

    .tab-item-off {
        font-size: 24px;
        font-weight: 400;
        color: rgb(154, 154, 157);
    }

    .tab-item-off:hover {
        font-size: 26px;
        text-decoration: none;
        color: black;
    }

    .tab-item-on:hover {
        text-decoration: none;
        color: black;
    }

    .space-top-40 {
        background-color: orange;
        height: 40px;
    }
</style>
