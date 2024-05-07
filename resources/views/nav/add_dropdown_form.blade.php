<form method="POST" action = "/add_dropdown">
    @csrf
    <div class="form-group" style = "margin:10px">
        <div class = "row">
            <input type="text" id = "drop_title" name = "drop_title" class = "new_item_input">
        </div>
    </div>
    <div style="border-top: 1px solid #000; margin-bottom:4px"></div>
    <div class="form-group" style = "margin:10px">
        <div id = "dropdown_list">
        </div>

        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <span>添加菜单项</span>
            <a href="#" style = "margin-left:12px" onClick = "createSubNavItem()">
                <img src="{{ asset('icons/add.svg') }}">
            </a>
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <!-- Ensure all columns are vertically aligned -->
            <button type="submit" class="btn btn-primary">
                保存
            </button>
        </div>
    </div>
    <input type="hidden" id="dropDownData" name="data">
    <input type="hidden" id="page_id" name="page_id">
    <input type="hidden" id="scroll_to" name="scroll_to">
    <input type= "hidden" id="key" name="key">
</form>
