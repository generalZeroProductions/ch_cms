@php
use Illuminate\Support\Facades\Log;
Log::info('hello from tabs');
    $tabCol = 'tab_col_' . $rowId;
    $contentCol = 'content_col_'.$rowId;
    $contentBoxId = 'content_'.$rowId;
    $tab0Route = $tab0->route;
    $tab0Index = $tab0->index;
    $tab0Id = $tab0->id;
    $tagAnchor = "tab_".$tab0->index;
@endphp

<div class="d-flex justify-content-start" id="{{ $rowId }}">
    <div class="col-6" id = "{{ $tabCol }}">
      @include('/tabs/tab_menu',['tabs'=>$tabs,'tab0'=>$tab0,'rowId'=>$rowId, 'divId'=>$tabCol])
    </div>
    <div class="col-6 " id="{{$contentCol}}">
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