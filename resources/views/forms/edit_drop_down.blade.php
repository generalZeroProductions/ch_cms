<form method="POST" action = "/update_drop_nav">
    @csrf
    <div class="form-group" style = "margin:20px">
    <div class = "row">
    <input type="text" id = "drop_title" name = "drop_title">
   
    </div>
        <div id = "dropdown_list">
            
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <span>Add Sub Nav</span >
            <a href="#" style = "margin-left:12px" onClick = "createSubNavItem()">
                <img src="{{ asset('icons/add.svg') }}">
            </a>
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px"> <!-- Ensure all columns are vertically aligned -->
            <button type="submit" class="btn">
                Confirm
            </button>
        </div>
    </div>
    <input type="hidden" id="dropDownData" name="data">
     <input type = "hidden" id = "drop_id" name = "drop_id">
    <input type="hidden" id="page_id" name="page_id">
</form>
