<form method="POST" action = "/update_dropdown">
    @csrf
    <div class="form-group" style = "margin:20px;">
        <label style="font-weight:600"> 下拉菜单标题 </label>
        <input class="form-control" type="text" id = "drop_title" name = "drop_title">
    </div>
    <hr>
    <div class="form-group" style = "margin:20px">
        <div id = "dropdown_list">

        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <span>添加子导航项</span>
            <a href="#" style = "margin-left:12px" onClick = "createSubNavItem()">
                <img src="{{ asset('icons/add.svg') }}">
            </a>
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <!-- Ensure all columns are vertically aligned -->
            <button type="submit" class="btn btn-primary">
                保存下拉菜单
            </button>
        </div>
    </div>
    <input type="hidden" id="dropDownData" name="data">
    <input type = "hidden" id = "drop_id" name = "drop_id">
    <input type="hidden" id="page_id" name="page_id">
    <input type="hidden" id="scroll_to" name="scroll_to">

</form>
