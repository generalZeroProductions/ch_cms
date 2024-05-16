@php
    $jDrop = json_encode(['page' => $page, 'row' => $row]);
@endphp
<br>
<br>
<div class="container-fluid yellow_row d-flex justify-content-center" id = "page_title_click" style="padding-top:8px"
    onclick="openMainModal('createRow','{{ $jDrop }}','modal-xl')">
    <div class = "row d-flex align-items-center">
        <p class="title-indicator">创建行</p>
        <img src={{ asset('icons/white_add.svg') }} class='add-row-plus'>
    </div>
</div>

<br>
<br>
<hr>

<style>
    .add-row-plus {
        height: 20px;
        margin-left: 8px;
        margin-bottom: 12px;
    }

    .yellow_row {
        background-color: rgb(248, 212, 135);
        height: 48px;
        margin-top: 12px;

    }

    .yellow_row:hover {
        cursor: pointer;
        background-color: rgb(249, 200, 95);
    }
</style>
