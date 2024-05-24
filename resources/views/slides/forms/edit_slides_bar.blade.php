@php

    $item = json_encode([
        'pageId' => $pageId,
        'rowId' => $rowId,
        'slides' => $slideJson,
        'slideHeight' => $slideHeight,
    ]);
    $changeHeightId = 'slide_height' . $rowId;
    $cantUseTag = 'cant_use'.$rowId;
    $sendHeight = 'send_height'.$rowId;
    $rowTag = 'slide_row_tag'.$rowId;
@endphp


<div class="container-fluid">
    <div class="row d-flex">

        <div class="col-4 green-bar d-flex justify-content-center" id = "page_title_click" style="padding-top:8px"
            onClick = "openMainModal('editSlideshow', '{{ $item }}','modal-xl')">
            <div class = "row d-flex align-items-center">
                <p class="title-indicator">编辑幻灯片</p>
                <img src={{ asset('icons/pen_white.svg') }} class='add-row-plus'>
            </div>
        </div>
        <div class = "col-4 green-back">
            <div class = "row d-flex align-items-center justify-content-center">
                <label class = "slide-height-label">片高度</label>
                <form id = 'change_slide_height'>
                @csrf
                    <input type="hidden" name = "form_name" value = "change_slide_height">
                    <input type="hidden" name = "row_id" id="{{$rowTag }}">
                    <input type="hidden" name = 'height' id="{{$sendHeight}}">
                </form>
                <input type = "text" class = "form-control slide-height-input " id="{{ $changeHeightId }}"
                    autocomplete="off" value="{{ $slideHeight }}" name ="height">
                <label  class = "pixel-label">像素</label>
                <button id="submit_slide_height_btn" class = "btn btn-primary slide-btn disabled" disabled>
                <img src = "{{asset('/icons/save.svg')}}" style="height:22px">
                </button>
            </div>
        </div>
        <div class="col-4 green-back">
            <p style= "color:yellow" id = "{{$cantUseTag}}" class = "slide-height-label"></p>
        </div>
    </div>
</div>

<div class="slide_scripts">

    <script>
        slideHeightListen('{{ $rowId }}', '{{ $slideHeight }}');
    </script>

</div>
<style>

.slide-btn{
    display:flex;
    margin-top:8px;
    width:36px !important;
    height:36px !important;
    padding:6px !important;
}
    .green-back {
        background-color: rgb(164, 241, 204);
    }

    .green-bar {
        background-color: rgb(164, 241, 204);
    }

    .green-bar:hover {
        cursor: pointer;
        background-color: rgb(106, 247, 179);
    }

    .slide-height-label {
        font-size: 16px;
        font-weight: 650;
        color: white;
        margin-left: 18px;
        margin-right: 10px;
        margin-top: 8px;
     
    }
     .pixel-label {
        font-size: 12px;
        font-weight: 650;
        color: white;
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 14px;
       
    }

    .slide-height-input {
        width: 90px !important;
        height: 34px !important;

        margin-top: 4px;
    }

    .space-top {
        margin-top: 8px;
    }
</style>

