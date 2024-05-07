<form method="POST" action = "/update_dropdown" id = "nav_dropdown" class = "wide-form">
    @csrf
    <div class="form-group" style = "margin:4px;">
        <label style="font-weight:600"> 下拉菜单标题 </label>
        <input class="form-control" type="text"  id="title" name ="title">
    </div>
    <hr>
    <div class="form-group" style = "margin:4px">
        <div id = "dropdown_list">
<!-- js created list of entries for sub navigation -->
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:14px ; margin-right:4px">
            <span>添加子导航项</span>
            <a href="#" style = "margin-left:12px" onClick = "createSubNavItem()">
                <img src="{{ asset('icons/add.svg') }}">
            </a>
        </div>
        <div class="row justify-content-end align-items-end" style = "margin-top:14px ; margin-right:4px">
            
            <button type="submit" class="btn btn-primary">
                保存下拉菜单
            </button>
        </div>
    </div>
    <input type="hidden" id="dropDownData" name="data">
    <input type = "hidden" id = "item_id" name = "item_id">
    <input type = "hidden" id = "key" name = "key">

    <input type="hidden" name="form_name" value = "dropdown_edit_form">
</form>


<style>
.local-ctl{
    margin-top:4px;
    height:28px !important;
    font-size:12px;
}
.wide-form{
    width:200px !important;
}

</style>