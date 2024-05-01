<style>
    .card-body:hover {
        background-color:rgb(248, 212, 135);
    }
</style>

<div class="d-flex justify-content-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">横幅/幻灯片</h5>
            <form method = "POST" action = "/create_slideshow">
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/banner.png') }} " width = "250"></button>
                <input type = "hidden" id='page_id_slide' name = 'page_id'>
                <input type = "hidden" id='row_index_slide' name = 'row_index_slide'>
                 <input type = "hidden" id='slide_scroll_to' name = 'scroll_to'>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">一栏文章</h5>
            <form method ="POST" action = "/create_one_column">
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/oneColumn.png') }} " width = "250"></button>
                <input type = "hidden" id='page_id_1col' name = 'page_id'>
                <input type = "hidden" id='row_index_1col' name = 'row_index_1col'>
                 <input type = "hidden" id='1col_scroll_to' name = 'scroll_to'>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">两栏文章</h5>
            <form method = 'POST' action = '/create_two_column'>
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/twoColumn.png') }} " width = "250"></button>
                <input type = "hidden" id='page_id_2col' name = 'page_id'>
                <input type = "hidden" id='row_index_2col' name = 'row_index_2col'>
                 <input type = "hidden" id='2col_scroll_to' name = 'scroll_to'>
            </form>
        </div>
    </div>


</div>
<div class="d-flex justify-content-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">选项卡内容</h5>
            <form method = "POST" action="/create_tabbed">
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/tabs.png') }} " width = "250"></button>
                <input type = "hidden" id='page_id_tab' name = 'page_id'>
                <input type = "hidden" id='row_index_tab' name = 'row_index_tab'>
                <input type = "hidden" id='tab_scroll_to' name = 'scroll_to'>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">文章 - 图片左/上 </h5>
            <form method = "POST" action="/create_image_article">
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/leftImage.png') }} " width = "250"></button>
                <input type = "hidden" id='page_id_left' name = 'page_id'>
                <input type = "hidden" id='row_index_left' name = 'row_index'>
                <input type = "hidden" id='left_scroll_to' name = 'scroll_to'>
                <input type = "hidden" name="image_at" value = "left">
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">文章 - 图片右/下</h5>
            <form method = "POST" action="/create_image_article">
                @csrf
                <button type="submit"> <img src ="{{ asset('icons/rightImage.png') }} " width = "250"></button>
                <input type = "hidden" id='page_id_right' name = 'page_id'>
                <input type = "hidden" id='row_index_right' name = 'row_index'>
                <input type = "hidden" id='right_scroll_to' name = 'scroll_to'>
                <input type = "hidden" name="image_at" value = "right">
            </form>
        </div>
    </div>
</div>
