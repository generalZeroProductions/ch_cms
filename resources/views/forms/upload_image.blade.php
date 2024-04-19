<form method="POST" action="/upload" enctype="multipart/form-data">
@csrf
    <div class="form-group">
        <label for="fileInput">Choose File</label>
        <input type="file" class="form-control-file" id="fileInput" name="file">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
    </div>
    <input type = "hidden" id="page_id" name = "page_id">
    <input type = "hidden" id = "column_id" name = "column_id">
</form>
