   <div class = "row">
       <form id = "edit_title_page">
           @csrf
           <input type = "text" id="edit_title_page_title" name = "title" class= "title-input">
           <input type = "hidden" id="page_id" name = "page_id">
           <input type= "hidden" name="form_name" value = "edit_title_page">
       </form>
       <button type="submit" class = "btn btn-primary page-title-save-btn" id="edit_title_page_btn">
           <img src="{{ asset('icons/save.svg') }}" class = "page-title-save-icon">
       </button>
      
   </div>

   <style>
       .page-title-save-icon {
           height: 22px;
       }
.title-input::placeholder{
color:white;
}
       .page-title-save-btn {
        margin-left:8px;
           display: flex;
           justify-content: center;
           align-items: center;
           border: none;
           cursor: pointer;
           height: 30px !important;
           width: 30px !important;
       }
   </style>
