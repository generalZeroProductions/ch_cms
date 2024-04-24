@if ($editMode)
    <hr>

    <button class = "btn btn-warning" onClick = "openBaseModal('createRow', null,'{{json_encode($location)}}')">
    <img src = {{asset('icons/white_add.svg')}} class='add_row_icon'>创建行</button>
@endif
