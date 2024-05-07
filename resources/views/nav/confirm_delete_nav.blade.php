<form method="POST" action='/delete_nav_item' id = "nav_delete">
    @csrf
    <div class="form-group group">
        <div class="row">
            <button type="submit" class="btn btn-danger col-auto buttons">
                删除
            </button>
            <button type="submit" class="btn btn-secondary col-auto buttons">
                取消
            </button>
        </div>
    </div>
    <input type="hidden" id="item_id" name="item_id">
    <input type = "hidden" name="form_name" value="delete_nav">
    <input type="hidden" id="scroll_to" name="scroll_to">
    <input type="hidden" id="location" name="location">
</form>


<style>
    .group {
        height: 22px;
        margin-right: 20px;
        margin-top: 12px;
    }

    .buttons {
        margin-left: 8px;
        width: 35px% !important;
        text-align: center !important;
        font-weight: 400;
    }
</style>
