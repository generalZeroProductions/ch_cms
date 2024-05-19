<form id = "dropdown_editor_nav" class = "wide-form">
    @csrf
    <div class="form-group" style = "margin:4px;">
        <label style="font-weight:600; font-size:12px; padding:0px!important;margin-bottom:0px "> 下拉菜单标题 </label>
        <input class="form-control local-ctl" type="text" id="dropdown_editor_nav_title" name ="title">
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
    </div>
    <input type="hidden" id="dropDownData" name="data">
    <input type="hidden" id="deleted_subs" name="deleted">
    <input type = "hidden" id = "item_id" name = "item_id">
    <input type = "hidden" id = "key" name = "key">
    <input type="hidden" name="form_name" value = "dropdown_editor_nav">
</form>

<div class="row justify-content-end align-items-end" style = "margin-top:14px ; margin-right:4px">

    <button class="btn btn-primary" id="dropdown_editor_nav_btn">
        保存下拉菜单
    </button>

</div>




<style>
    .local-ctl {
        margin-top: 4px;
        height: 28px !important;
        font-size: 12px;
    }

    .local-ctl::placeholder {
        color: white;
    }

    .wide-form {
        width: 200px !important;
    }
</style>
