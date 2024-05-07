<form method="POST" action = "/delete_page">
    @csrf
    <div class="form-group" style = "margin:0px">
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger col-auto" id="delete_btn">
                <!-- Button content goes here -->
            </button>
        </div>
    </div>
    <input type="hidden" id="row_id" name="row_id" class="col-auto">
    <input type="hidden" id="page_id" name="page_id" class="col-auto">
    <input type="hidden" id="scroll_to" name="scroll_to" class="col-auto">
</form>