<form method="POST" action = "/update_article">
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
    <button type="button" class="btn btn-secondary">Cancel</button>
    <input type="hidden" name="body_text" id = "body_text">
    <input type="hidden" name="article_id" id = "article_id">
    <input type="hidden" name="page_id" id = "page_id">
       <input type="hidden" id="scroll_to" name="scroll_to">
</form>
