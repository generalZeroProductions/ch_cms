<style>
    .card-body:hover {
        background-color: rgb(248, 212, 135);
    }
</style>

<div class="d-flex justify-content-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">横幅/幻灯片</h5>
            <form method = "POST" action = "/create_slideshow" id='create_slides_form'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/new_row_images/banner.png') }} "
                        width = "100%"></button>
                <input type = "hidden" id='page_id_slide' name = 'page_id'>
                <input type = "hidden" id='row_index_slide' name = 'row_index_slide'>
                <input class=rs-scroll type="hidden" name = "scroll_to">
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">一栏文章</h5>
            <form method ="POST" action = "/create_one_column" id='create_one_form'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/new_row_images/oneColumn.png') }} "
                        width = "100%"></button>
                <input type = "hidden" id='page_id_1col' name = 'page_id'>
                <input type = "hidden" id='row_index_1col' name = 'row_index_1col'>
                <input class=rs-scroll type="hidden" name = "scroll_to">
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">两栏文章</h5>
            <form method = 'POST' action = '/create_two_column' id='create_two_form'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/new_row_images/twoColumn.png') }} "
                        width = "100%"></button>
                <input type = "hidden" id='page_id_2col' name = 'page_id'>
                <input type = "hidden" id='row_index_2col' name = 'row_index_2col'>
                <input class=rs-scroll type="hidden" name = "scroll_to">
            </form>
        </div>
    </div>


</div>
<div class="d-flex justify-content-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">选项卡内容</h5>
            <form method = "POST" action="/create_tabbed" id='create_tabs_form'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/new_row_images/tabs.png') }} "
                        width = "100%"></button>
                <input type = "hidden" id='page_id_tab' name = 'page_id'>
                <input type = "hidden" id='row_index_tab' name = 'row_index_tab'>
                <input class=rs-scroll type="hidden" name = "scroll_to">
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">文章 - 图片左/上 </h5>
            <form method = "POST" action="/create_image_article" id='create_left_form'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/new_row_images/leftImage.png') }} "
                        width = "100%"></button>
                <input type = "hidden" id='page_id_left' name = 'page_id'>
                <input type = "hidden" id='row_index_left' name = 'row_index'>
                <input type = "hidden" name="image_at" value = "left">
                <input class=rs-scroll type="hidden" name = "scroll_to">
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">文章 - 图片右/下</h5>
            <form method = "POST" action="/create_image_article" id='create_right_form'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/new_row_images/rightImage.png') }} "
                        width = "100%"></button>
                <input type = "hidden" id='page_id_right' name = 'page_id'>
                <input type = "hidden" id='row_index_right' name = 'row_index'>
                <input type = "hidden" name="image_at" value = "right">
                <input class=rs-scroll type="hidden" name = "scroll_to">
            </form>
        </div>
    </div>
</div>
