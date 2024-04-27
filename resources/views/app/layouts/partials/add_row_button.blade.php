<hr>
<div class="container-fluid yellow_row" style='height:5.2vh'>
    <div class="row">
        <div class="col-md-10" id = "{{ $index }}">
        </div>
        <div class="col-6 col-md-2">
            <button class = "btn btn-warning general-btn add_row_btn"
                onClick = "openBaseModal('createRow', '{{ $index }}','{{ json_encode($location) }}')">
                创建行<img src={{ asset('icons/white_add.svg') }} class='space_icon_right'></button>
            <br>
        </div>
    </div>
</div>
<br>
<style>
   
</style>
