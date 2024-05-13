<div class="container-fluid blue_row d-flex justify-content-center" id = "page_title_click" style="padding-top:8px">
    <div class = "row d-flex align-items-center"
        onclick="insertForm('edit_title_page', '{{ json_encode($page) }}', 'page_title_click') ">
        <p class="title-indicator">页面名称:</p>
        <p class="title_reference">{{ $page->title }}</p>
        <img src="{{ asset('icons/pen_white.svg') }}" class="edit-title-pen">
    </div>
</div>

<style>
    .blue_row:hover {
        background-color: rgb(141, 145, 255);
        cursor: pointer;
    }

    .blue-flat {
        background-color: rgb(178, 180, 249);
        height: 44px;
    }

    .edit-title-pen {
        height: 20px;
        margin-left: 6px !important;
        margin-bottom: 10px !important;
    }
</style>
