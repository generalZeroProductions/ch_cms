@php
    $tabCol = 'tab_col_' . $rowId;
    $contentBoxId = 'content_'.$rowId;
    $tab0Route = $tab0->route;
    $tab0Index = $tab0->index;
    $tab0Id = $tab0->id;
    $tagAnchor = "tab_".$tab0->index;
    $pageId = $location['page']['id'];
@endphp

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
      @include('/tabs/tab_menu',['tabs'=>$tabs,'tab0'=>$tab0,'rowId'=>$rowId])
    </div>
    <div class="col-9 ">
            <div id="{{ $contentBoxId }}" class="tabContent_{{ $rowId }}">
            </div>
    </div>
</div>


<div class = 'run-scripts'>
<script>
    changeTab('{{ $rowId }}', '{{$tagAnchor }}', '{{ $tab0Index }}','{{$tab0Id}}');
</script>
</div>
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
