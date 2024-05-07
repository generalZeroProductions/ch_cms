<div class="d-flex yellow_row">
    <div class="col-10">
    </div>
    <div class="col-2 d-flex justify-content-center align-items-center">
        <button class = "btn  btn-warning add_row_btn btn-44"
            onClick = "openMainModal('createRow', '{{ $index }}','{{ json_encode($location) }}','modal-xl')">
            创建行<img src={{ asset('icons/white_add.svg') }}></button>

    </div>
</div>
<br>
<hr>

<style>
    .yellow_row {
        background-color: rgb(248, 212, 135);
        height: 48px;
        margin-top: 12px;
        
    }

    .btn-44 {
        height: 44px;
        font-size: medium;
        font-weight: 600;
        width:100px;
    }

    .add_row_btn {
        color: white !important;
    }

    .add_row_btn:hover span {
        color: white !important;
    }
</style>
