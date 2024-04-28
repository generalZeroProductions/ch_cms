@if($index===1)
@endif
<div class="container-fluid yellow_row" style='height:5.2vh'>
    <div class="d-flex bd-highlight ">
        <div class="p-2 w-100 bd-highlight"></div>
        <div class="p-2 flex-shrink-1 bd-highlight btn-right-space no-top-space ">
            <button class = "btn btn-warning general-btn add_row_btn"
                onClick = "openMainModal('createRow', '{{ $index }}','{{ json_encode($location) }}','modal-xl')">
                创建行<img src={{ asset('icons/white_add.svg') }} class='space_icon_right'></button>
        </div>
    </div>
</div>
<br>
<br>
<hr>
