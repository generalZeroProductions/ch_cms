@php
$jDrop = json_encode(['page'=>$page, 'row'=>$row])
@endphp

<br><br>


<div class="container-fluid red_row d-flex justify-content-center" id = "page_title_click" style="padding-top:8px"
 onclick="openMainModal('removeRow', '{{ $jDrop }}','modal-sm')">
    <div class = "row d-flex align-items-center" >
        <p class="title-indicator">删除行</p>
        <img src={{ asset('icons/trash_white.svg') }} class='delete-row-trash'>
    </div>

</div>

<style>
.delete-row-trash{
    height:20px;
    margin-left:8px;
    margin-bottom:14px
}
.red_row:hover{
    cursor:pointer;
    background-color:rgb(253, 137, 137);
}

</style>