<form id="add_standard">
    @csrf
    <input type= "hidden" name = "form_name" value="add_standard_nav">
    <input type= "hidden" id="standard_key" name="key">
</form>


<form id="add_dropdown">
    @csrf
    <input type= "hidden" name = "form_name" value="add_dropdown_nav">
    <input type= "hidden" id="dropdown_key" name="key">
</form>



<div class="d-flex justify-content-start nav_select">
    <div class="p-2">
        <button class="btn btn-primary new-nav-select" id = "add_standard_btn">
            基本导航
        </button>
    </div>
    <div class="p-2">
        <button class="btn btn-primary new-nav-select" id="add_dropdown_btn">
            下拉导航
        </button>
    </div>
    <div class="p-2">
        <button id = "cancel_add_nav" class="btn btn-secondary new-nav-cancel">
            <img src="{{ asset('/icons/close.svg') }}" class=cancel>
        </button>
    </div>
</div>


<style>
    .nav_select {
        width: 160px !important;
        padding-top:4px;
    }

    .new-nav-select {
        text-align: center !important;
        width: 80px;
        height: 34px;
        margin-right: 6px;
        padding: 0px;
    }

    .new-nav-cancel {
        background-color: white !important;
        text-align: center !important;
        width: 38px;
        height: 32px;
        margin-right: 0px;
        padding: 0px;
        border: none;
    }

    .cancel {
        height: 32px;
    }
</style>
