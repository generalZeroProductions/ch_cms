<form method="POST" action = "/submit_update_article">
    @csrf
    <div class="form-group">
        <div class="d-flex flex-column mb-3">
            <div class="p-2 ">
                <h4>文章标题</h4>
            </div>
            <div class="p-2 ">
                <input type="text" class="form-control yellow-back" id="article_title" name="title">
            </div>
            <div class="p-2 ">
                <textarea class="form-control yellow-back long-text" maxlength="8000" id ="article_body" name="body"></textarea>
            </div>
            <div class="p-2 ">
                <div class="d-flex justify-content-end">
                    <div class="p-2 ">
                        <button type="button" id="cancel_article" class="btn btn-secondary">Cancel</button>
                    </div>
                    <div class="p-2 ">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" name="article_id" id = "article_id">
    <input type="hidden" name="page_id" id = "page_id">
    <input type="hidden" id="scroll_to" name="scroll_to">
    </div>


    <style>
        .yellow-back {
            background-color: rgb(250, 248, 220);
        }

        .long-text {
            height: 500px
        }


        .chinese-font {
            font-family: "Hanyi Senty";
        }

        /* Apply the CSS class to elements containing Chinese text */
        .chinese-text {
            font-family: "STFangSong", "华文仿宋", sans-serif;
        }
    </style>
