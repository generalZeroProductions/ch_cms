<form method="POST" action = "console/delete_user">
<input type="hidden" id="scrollDash" name = "scrollDash">
    @csrf
    <div class="form-group" style = "margin:0px">
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger col-auto" id="delete_user_btn">
                删除
            </button>
        </div>
    </div>
    <input type="hidden" id="user_id" name="user_id" class="col-auto">
</form>