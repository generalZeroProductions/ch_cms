<form method="POST" action = "/delete_row">
    @csrf
    <div class="row justify-content-center">
        <button type="submit" class="btn btn-danger col-auto" id="delete_btn">
            确认删除行
        </button>
    </div>
    <input type="hidden" id="row_id" name="row_id" class="col-auto">
    <input type="hidden" id="page_id" name="page_id" class="col-auto">
    <input type="hidden" id ="scroll_to" name = "scroll_to">
</form>
