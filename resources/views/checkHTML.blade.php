<div class="container-fluid red_row d-flex justify-content-center" id = "page_title_click" style="padding-top:8px"
    onclick="openMainModal('removeRow', '{&quot;page&quot;:{&quot;id&quot;:3,&quot;created_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;type&quot;:&quot;page&quot;,&quot;heading&quot;:null,&quot;title&quot;:&quot;Page_1&quot;,&quot;body&quot;:null,&quot;image&quot;:null,&quot;index&quot;:null,&quot;data&quot;:{&quot;rows&quot;:[2]},&quot;styles&quot;:null},&quot;row&quot;:{&quot;id&quot;:2,&quot;created_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;type&quot;:&quot;row&quot;,&quot;heading&quot;:&quot;one_column&quot;,&quot;title&quot;:null,&quot;body&quot;:null,&quot;image&quot;:null,&quot;index&quot;:1,&quot;data&quot;:{&quot;columns&quot;:[1]},&quot;styles&quot;:null}}','modal-sm')">
    <div class = "row d-flex align-items-center">
        <p class="title-indicator">删除行</p>
        <img src=http://192.168.0.90/icons/trash_white.svg class='delete-row-trash'>
    </div>

</div>

<style>
    .delete-row-trash {
        height: 20px;
        margin-left: 8px;
        margin-bottom: 14px
    }

    .red_row:hover {
        cursor: pointer;
        background-color: rgb(253, 137, 137);
    }
</style>
<div class = 'container-fluid'>
    <div class = 'container'>
        <div class = "row">
            <div class="col-md-12" id = "article_2">
                <div style="width:100%" id="article_2">
                    <div class="d-flex align-items-center icon-space">
                        <a style= "cursor: pointer;"
                            onClick = "insertForm('edit_text_article','{&quot;pageId&quot;:3,&quot;rowId&quot;:2,&quot;article&quot;:{&quot;id&quot;:1,&quot;created_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-05-14T10:12:18.000000Z&quot;,&quot;type&quot;:&quot;column&quot;,&quot;heading&quot;:&quot;title_text&quot;,&quot;title&quot;:&quot;PagZ 1 Shizl&quot;,&quot;body&quot;:&quot;This is some sample content.&quot;,&quot;image&quot;:null,&quot;index&quot;:null,&quot;data&quot;:{&quot;info&quot;:[2]},&quot;styles&quot;:{&quot;info&quot;:&quot;on&quot;,&quot;title&quot;:&quot;t3&quot;}},&quot;info&quot;:{&quot;id&quot;:2,&quot;title&quot;:&quot;info&quot;,&quot;type&quot;:&quot;info&quot;,&quot;route&quot;:&quot;\/login&quot;,&quot;index&quot;:null,&quot;data&quot;:null,&quot;styles&quot;:{&quot;type&quot;:&quot;button&quot;},&quot;created_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;}}',  'article_2')">
                            <img src="http://192.168.0.90/icons/pen.svg" class="pen-icon">
                        </a>
                    </div>
                    <div class=t3> PagZ 1 Shizl</div>
                    <div> This is some sample content.</div>

                </div>
                <div>
                    <button onClick="window.location='/login'">
                        info
                    </button>
                </div>




                <style>
                    .pen-icon {
                        margin-left: 10px;
                        height: 18px
                    }

                    .icon-space {
                        height: 48px;
                    }

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
                </style>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid yellow_row d-flex justify-content-center" id = "page_title_click" style="padding-top:8px"
    onclick="openMainModal('createRow','{&quot;page&quot;:{&quot;id&quot;:3,&quot;created_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;type&quot;:&quot;page&quot;,&quot;heading&quot;:null,&quot;title&quot;:&quot;Page_1&quot;,&quot;body&quot;:null,&quot;image&quot;:null,&quot;index&quot;:null,&quot;data&quot;:{&quot;rows&quot;:[2]},&quot;styles&quot;:null},&quot;row&quot;:{&quot;id&quot;:2,&quot;created_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-05-13T22:41:39.000000Z&quot;,&quot;type&quot;:&quot;row&quot;,&quot;heading&quot;:&quot;one_column&quot;,&quot;title&quot;:null,&quot;body&quot;:null,&quot;image&quot;:null,&quot;index&quot;:1,&quot;data&quot;:{&quot;columns&quot;:[1]},&quot;styles&quot;:null}}','modal-xl')">
    <div class = "row d-flex align-items-center">
        <p class="title-indicator">创建行</p>
        <img src=http://192.168.0.90/icons/white_add.svg class='add-row-plus'>
    </div>

</div>

<br>
<hr>

<style>
    .add-row-plus {
        height: 20px;
        margin-left: 8px;
        margin-bottom: 12px;
    }

    .yellow_row {
        background-color: rgb(248, 212, 135);
        height: 48px;
        margin-top: 12px;

    }

    .yellow_row:hover {
        cursor: pointer;
        background-color: rgb(249, 200, 95);
    }
</style>
</div>
