<form id = "edit_footer_item">
    @csrf
    <input type="hidden" name="data" id="store_footer_data">
    <input type="hidden" name="deleted" id="delete_footer_data">

    <input type="hidden" name = "form_name" value = "edit_footer_item">
</form>
<div class = "container">
    @include('app.footer_item_edit_bar')
    <div class = "row">

        <div class=col-12 id="footer_items_list">
        </div>
        <br>
    </div>

<div class = "row" id= "show_me_ht"></div>
    <div class="row">
        <div class = "col-6  foot-ctls-left" id="delete_footer">
            <a style="cursor:pointer" onclick="deleteFooter()"> <img src="{{ asset('icons/trash.svg') }}"></a>
            <span class="add-label"> remove a footer</span>
        </div>


        <div class = "col-6 foot-ctls-right">
            <span class="add-label"> add a footer</span>
            <a style="cursor:pointer" onclick="newFooter()"> <img src="{{ asset('icons/add.svg') }}"></a>
        </div>

    </div>
</div>
@php

@endphp
@include('forms.add_link_modal')
<style>
    .foot-ctls-right {
        padding-right: 12px;
        text-align: right;
    }

    .foot-ctls-left {
        padding-left: 12px;
        text-align: left;
    }

    .add-label {
        padding-right: 8px;
    }
</style>
