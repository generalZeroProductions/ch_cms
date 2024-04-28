
<div class="container-fluid green_row">
    <div class="row">
        <div class = 'col-lg-5 col-sm-0 col-white'></div>
        <div class="col-lg-2 col-sm-12 d-flex justify-content-center">
            <div class = "row row-middle-edits">
                <a href="#" style=" text-decoration: none;"
                 onClick = "openMainModal('editSlideshow', '{{ json_encode($slideJson) }}','{{ json_encode($location) }}','modal-xl')"
                    class="d-flex align-items-center">
                    <p class="title-indicator">编辑幻灯片:</p>
                    <img src="{{ asset('icons/pen_white.svg') }}" class="space_icon_right-sm">
                </a>
            </div>
        </div>
        <div class = 'col-lg-5 col-sm-0 col-white'></div>
    </div>
</div>
<br>
