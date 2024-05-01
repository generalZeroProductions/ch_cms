{{-- <form method="POST" action = "/submit_update_article">
    @csrf
    <div class="form-group">
        <h4>文章标题</h4>
        <input type="text" class="form-control" id="edit_article_title" name="title">
    </div>
    <h4>文章正文</h4>
    <!-- Hidden input field to capture the content -->
    <div id="edit_article_body" name="body" class="article_edit" contenteditable="true">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="button" id="cancel_article" class="btn btn-secondary">Cancel</button>
    <input type="hidden" name="body_text" id = "body_text">
    <input type="hidden" name="article_id" id = "article_id">
    <input type="hidden" name="page_id" id = "page_id">
    <input type="hidden" id="scroll_to" name="scroll_to">
</form> --}}
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


    <script>
        tinymce.init({
            selector: '#article_body',
            plugins: 'autolink lists link',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link'
        });
    </script>


    <style>
        .yellow-back {
            background-color: rgb(250, 248, 220);
        }

        .long-text {
            height: 500px
        }
    </style>
