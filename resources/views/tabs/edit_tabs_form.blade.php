<form id="edit_tabs">
    @csrf
    <div class="form-group" style = "margin:20px">
        <div id = "tab_list">
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <span>Add Tab</span>
            <a href="#" style = "margin-left:12px" onClick = "createTabItem()">
                <img src="{{ asset('icons/add.svg') }}">
            </a>
        </div>
        <input type="hidden" id="tabData" name="data">
        <input type="hidden" id="row_id" name="row_id">
        <input type="hidden" id="edit_tabs" name = "edit_tabs">
        <input type="hidden" id="route_list">
    </div>
</form>
<div class="row justify-content-end align-items-end" style = "margin-top:10px">
    <!-- Ensure all columns are vertically aligned -->
    <button class="btn btn-primary" id="edit_tabs_btn">
        <img src="{{ asset('icons\save.svg') }}" class = "save-icon">
    </button>
</div>
