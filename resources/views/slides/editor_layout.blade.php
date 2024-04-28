
<form method="POST"></form>
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
<button type="submit" class="btn">save slide show</button>
</form>
<style>
    .card {
        margin: 12px !important;
        width: 90% !important;
        border: none !important;
    }
    .standin{
    height: 100px;
    background-color: black;
}
</style>
