<form method="POST" action="/update_slideshow" enctype="multipart/form-data" id="slideEditForm">
@csrf
<div class="d-flex justify-content-between">
    @for ($i = 0; $i < 3; $i++)
        <div class="card" id = "card{{ $i }}">
        <div class = "standin"></div>
        </div>
    @endfor
</div>
<div class="d-flex justify-content-between">
    @for ($i = 3; $i < 6; $i++)
        <div class="card" id = "card{{ $i }}">
       <div class = "standin"></div>
        </div>
    @endfor
</div>
<input type = "hidden" id="row_id" name = "row_id">
<input type = "hidden" id="page_id" name = "page_id">
<input type = "hidden" id="scroll_to" name = "scroll_to">
<input type = "hidden" id="slide_show_data" name = "data">
<div class="d-flex bd-highlight">
  <div class="p-2 w-100 "></div>
  <div class="p-2 flex-shrink-1">
  <button type="submit" class="btn btn-success">
            保存幻灯片  
        </button>
  </div>
</div>
  
</form>
<style>
    .card {
        margin: 12px !important;
        width: 90% !important;
        border: none !important;
    }
    .standin{
    height: 100px;
    background-color: white;
}
</style>
