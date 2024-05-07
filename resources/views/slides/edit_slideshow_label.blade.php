
<div class="container-fluid green-edit">
    <div class="row flex-d space-top">
        <div class = 'col-10'></div>
        <div class="col-2 d-flex justify-content-start align-items-center">
            <div class = "row">
                <button href="#" class = "btn btn-primary"
                 onClick = "openMainModal('editSlideshow', '{{ json_encode($slideJson) }}','{{ json_encode($location) }}','modal-xl')">
                    编辑幻灯片:
                    <img src="{{ asset('icons/pen_white.svg') }}">
                </button>
            </div>
        </div>

    </div>
</div>
<br>

<style>
.green-edit{
    background-color:rgb(127, 228, 137);
}
.space-top{
    margin-top:8px;
}
</style>
