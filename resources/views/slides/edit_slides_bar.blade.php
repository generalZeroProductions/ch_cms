@php

    $item = json_encode(['pageId' => $pageId, 'rowId' => $rowId, 'slides' => $slideJson, 'slideHeight'=>$slideHeight]);
    $changeHeightId = 'slide_height'.$rowId;
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
                <input type="hidden" name = "form_name" value = "change_slide_height">
                <input type="hidden" name = "row_id" id="slide_height_row_id">
                <input type="hidden" name = 'height' id="height">
                </form>
                 <input type = "text" class = "form-control slide-height-input " 
                    id="{{$changeHeightId}}" autocomplete="off" value="{{$slideHeight}}" name ="height">
                <label class = "slide-height-label">像素</label>
            </div>
        </div>
         <div class="col-4 green-back">
         <p id = "not_usable" class = "slide-height-label">this number too small</p>
         </div>
    </div>
</div>

<div class="slide_scripts">

<script>
slideHeightListen('{{$rowId}}','{{$slideHeight}}');
</script>

</div>
<style>
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
    .slide-height-input {
        width: 90px !important;
        height: 34px !important;
       
        margin-top: 4px;
    }

    .space-top {
        margin-top: 8px;
    }
</style>
{"height":["300"]}