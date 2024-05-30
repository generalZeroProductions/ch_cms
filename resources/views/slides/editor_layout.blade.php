
    <div class="d-flex justify-content-between">
        @for ($i = 0; $i < 3; $i++)
            <div class="card card-240" id = "card{{ $i }}">
                <div class = "standin"></div>
            </div>
        @endfor
    </div>
    <div class="d-flex justify-content-between">
        @for ($i = 3; $i < 6; $i++)
            <div class="card card-240" id = "card{{ $i }}">
                <div class = "standin"></div>
            </div>
        @endfor
    </div>
    <form method="POST" action="/update_slideshow" enctype="multipart/form-data" id="slideEditForm">
    @csrf
    <input type = "hidden" id="row_id" name = "row_id">
    <input type = "hidden" id="page_id" name = "page_id">
    <input type = "hidden" id="scroll_to" name = "scroll_to">
    <input type = "hidden" id="slide_show_data" name = "data">
    <input type = "hidden" id="deleted_slides" name = "deleted">
    <div class="row d-flex bd-highlight">
    <div class="col-8"></div>
        <div class="col-2 justify-content-end " id ="cant_sumbit_slides" style ="color:red"></div>
        <div class="col-2 flex-shrink-1">
            <button type="submit" class="btn btn-success" id="submit_slideshow_btn">
                保存幻灯片
            </button>
        </div>
    </div>

</form>
<style>
    .card-240 {
        margin: 12px !important;
        width: 90% !important;
        height: 230px !important;
        border: none !important;
    }

    .standin {
        height: 100px;
        background-color: white;
    }
</style>
