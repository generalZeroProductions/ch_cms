<form method="POST" action = "/update_tabs">
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
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <!-- Ensure all columns are vertically aligned -->
            <button type="submit" class="btn">
                Confirm
            </button>
        </div>
        <input type="hidden" id="tabData" name="data">
        <input type="hidden" id="row_id" name="row_id">
        <input type="hidden" id="page_id" name="page_id">
        <input type="hidden" id="route_list">
</form>
