 <div class="container-fluid blue_row d-flex justify-content-center  hide-editor" id = "page_title_click" style="padding-top:8px"
     onclick="insertForm('edit_title_page', '{{ json_encode($page) }}', 'page_title_click') ">
     <div class = "row d-flex align-items-center">
         <p class="title-indicator">页面名称:</p>
         <p class="title_reference">{{ $page->title }}</p>
         <img src="{{ asset('icons/pen_white.svg') }}" class="edit-title-pen">
     </div>

 </div>
 <div class=" d-flex justify-content-center">
     <p id="no_duplicates" style="color:red; margin-left:12px; display:none">页面标题与现有页面重复 </p>
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
         height: 18px;
         margin-left: 8px !important;
         margin-bottom: 13px !important;
     }
 </style>
