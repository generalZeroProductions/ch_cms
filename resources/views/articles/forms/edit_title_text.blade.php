<form id = "edit_title_text">
    @csrf
    <div class="form-group">
        <div class="d-flex flex-column mb-3">
            <div class="p-2 ">
                <h5>文章标题</h5>
            </div>

            <div class= "row flex-d">
                <div class = "col-9">
                    <input type="text" class="form-control t1" id="edit_title_text_title" name="title">
                </div>

                <div class = "col-2">
                    <select class= "form-control" id="size_select">
                        <option value = '1'>最大</option>
                        <option value = '2'>大</option>
                        <option value = '3'>标准 </option>
                        </option>
                        <option value = '4'> 小</option>
                        <option value = '5'>最小</option>

                    </select>
                </div>
                <div class = " col-1">
                    <a href = "#">
                        <img src="{{ asset('icons/palette.svg') }}" style="height:32px">
                    </a>
                </div>
            </div>

            <div class="p-2 ">
                <textarea class="form-control yellow-back long-text" maxlength="8000" id ="edit_title_text_body" name="body"></textarea>
            </div>
        </div>
    </div>

    <input type="hidden" name="article_id" id = "article_id">
    <input type="hidden" name="row_id" id = "row_id">
    <input type="hidden" id="title_size" name = "title_size">
    <input type = "hidden" id="title_color" name="title_color">
    <input type="hidden" name ="edit_title_text" value="edit_title_text">

</form>

<div class="d-flex justify-content-end">
    <div class="p-2 ">
        <button type="button" id="cancel_article" class="btn btn-secondary">
        <img src="{{asset('icons/cancel.svg')}}">
        </button>
    </div>
    <div class="p-2 ">
        <button id = "edit_title_text_btn" class="btn btn-primary">
         <img src="{{asset('icons/save.svg')}}">
        </button>
    </div>
</div>



<style>
    .long-text {
        height: 500px
    }

    .t1 {
        /* X_L */
        font-size: 40px;
        font-weight: bold;
    }

    .t2 {
        /* L */
        font-size: 36px;
        font-weight: bold;
    }

    .t3 {
        /* M */
        font-size: 32px;
        font-weight: bold;
    }

    .t4 {
        /* S */
        font-size: 28px;
        font-weight: bold;
    }

    .t5 {
        /* X_S */
        font-size: 24px;
        font-weight: bold;
    }




    .chinese-font {
        font-family: "Hanyi Senty";
    }

    /* Apply the CSS class to elements containing Chinese text */
    .chinese-text {
        font-family: "STFangSong", "华文仿宋", sans-serif;
    }
</style>
