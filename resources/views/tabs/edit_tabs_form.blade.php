<form id="edit_tabs">
    @csrf
    <div class="form-group" style = "margin:20px">
        <div id = "tab_list">
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:10px">
            <span>新选项卡</span>
            <a  style = " cursor:pointer; margin-left:12px" onClick = "createTabItem()">
                <img src="{{ asset('icons/add.svg') }}">
            </a>
        </div>
        <input type="hidden" id="tabData" name="data">
        <input type="hidden" id="row_id" name="row_id">
        <input type="hidden" id="edit_tabs" name = "edit_tabs">
        <input type="hidden" id="route_list">
         <input type="hidden" name="form_name" value="edit_tabs">
    </div>
</form>
<div class="row justify-content-end align-items-end" style = "margin-top:10px; padding-right:20px;">
    <!-- Ensure all columns are vertically aligned -->
    <button class="btn btn-primary" id="edit_tabs_btn">
        <img src="{{ asset('icons\save.svg') }}" class = "save-icon-tabs">
    </button>
</div>
<div id = "dataUpdate"></div>
<style>
.save-icon-tabs{
    height:24px;
}
.tab-title{
    width:136px !important;
}
.tab-title::placeholder{
    color:white !important;
}

.tab-trash-icon{
    margin-top:4px;
    height:22px;
    margin-right:10px;

}

 .trashcan{
        cursor:pointer;
    }
.tab-link-icon{
    height:18px;
    margin-top:8px;
    margin-right:4px;
    margin-left:4px;
}
</style>