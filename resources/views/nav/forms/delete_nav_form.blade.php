<form id = "nav_delete">
    @csrf
    <input type="hidden" id="item_id" name="item_id">
    <input type="hidden" id = "key" name = "key">
    <input type = "hidden" name="form_name" value="nav_delete">
</form>

<div class="row group">
    <button class="btn btn-danger  buttons" id="delete_nav_btn">
        删除
    </button>
    <button class="btn btn-secondary  buttons" id = "cancel_delete_btn">
        取消
    </button>
</div>
<style>
    .group {
        height: 22px;
        margin-top: 9px;
        margin-left: 18px;
        margin-right: 18px;

    }

    .buttons {
        margin-left: 8px;
        width: 35px% !important;
        text-align: center !important;
        font-weight: 400;
    }
</style>
