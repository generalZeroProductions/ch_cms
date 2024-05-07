<div class="d-flex justify-content-start">
    <div class="p-2">
        <form method='POST' action = "/new_nav_item" id="add_standard">
        @csrf
            <button type=submit class="btn btn-primary new-nav-select">
                基本导航
            </button>
            <input type= "hidden" name = "scroll_to" id="standard_scroll">
            <input type= "hidden" name = "location" id="standard_loc">
            <input type= "hidden" name = "form_name" value="nav_add_standard">
            <input type= 'hidden' name=item_id id="standard_item_id">
             <input type= "hidden" id="standard_key" name="key">
        </form>
    </div>
    <div class="p-2">
        <form method='POST' action = "/add_dropdown" id="add_standard">
        @csrf
            <button class="btn btn-primary new-nav-select">
                下拉导航
            </button>
            <input type= "hidden" name = "scroll_to" id="drop_scroll">
            <input type= "hidden" name = "location" id="drop_loc">
            <input type= "hidden" name = "form_name" value="nav_add_dropdown">
            <input type= 'hidden' name=item_id id="dropdown_item_id">
            <input type= "hidden" id="dropdown_key" name="key">
        </form>


    </div>
    <div class="p-2">
        <form>
            <button class="btn btn-secondary new-nav-cancel">
                <img src="{{ asset('/icons/close.svg') }}" class=cancel>
            </button>
            <input type= "hidden" name = "scroll_to" id="cancel_scroll">
            <input type= "hidden" name = "location" id="cancel_loc">
            <input type= "hidden" name = "form_name" value="nav_add_cancel">
            <input type= 'hidden' name=item_id id="cancel_item_id">
             <input type= "hidden" id="cancel_key" name="key">

        </form>
    </div>
</div>


<style>
    .new-nav-select {

        text-align: center !important;
        width: 80px;
        height: 36px;
        margin-right: 6px;
        padding: 0px;
    }

    .new-nav-cancel {
        background-color: white !important;
        text-align: center !important;
        width: 38px;
        height: 36px;
        margin-right: 0px;
        padding: 0px;
        border: none;
    }

    .cancel {
        height: 32px;
    }
</style>
