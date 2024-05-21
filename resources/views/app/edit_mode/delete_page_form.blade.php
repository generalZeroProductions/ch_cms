<form method="POST" action = "/delete_page">
    @csrf
    <div class="form-group" style = "margin:0px">
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger col-auto" id="delete_page_btn">
                删除
            </button>
        </div>
    </div>
    <input type="hidden" id="page_id" name="page_id" class="col-auto">
</form>