@php
    $id = $location['row']['id'];

@endphp

<br><br>
<div class="container-fluid red_row" style='height:5.2vh'>
    <div class="d-flex bd-highlight ">
        <div class="p-2 w-100 bd-highlight"></div>
        <div class="p-2 flex-shrink-1 bd-highlight btn-right-space no-top-space ">
            <button class = "btn btn-danger general-btn">
                删除行 <img src={{ asset('icons/trash_white.svg') }} class='space_icon_right'></button>
        </div>
    </div>
</div>

