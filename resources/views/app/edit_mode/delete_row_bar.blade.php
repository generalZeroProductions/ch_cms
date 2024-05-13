@php
@endphp

<br><br>
<div class="container-fluid red_row" style='height:46px'>
    <div class="d-flex bd-highlight ">
        <div class="p-2 w-100 "></div>
        <div class="p-2 flex-shrink-1 btn-right-space no-top-space ">
            <button class = "btn btn-danger general-btn" onClick="openMainModal('removeRow','null', '{{ json_encode($row) }}','model-sm')">
                删除行 <img src={{ asset('icons/trash_white.svg') }} class='space_icon_right'></button>
        </div>
    </div>
</div>

