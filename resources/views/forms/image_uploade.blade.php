@php
$imageNames = [];
$directory = public_path('storage/images'); // Adjust the directory path as per your setup
$files = scandir($directory);
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        $imageNames[] = pathinfo($file, PATHINFO_FILENAME);
    }
}
@endphp
<form id="fileUploadForm" action="/uploadImage" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{$row->id}}" name="rowName">
    <div class="form-group">
        <label for="imageNameInput">Image Name</label>
        <input type="text" class="form-control" id="imageNameInput" name="imageName" value="{{$row->image}}" required>
        <small class="form-text text-muted">Please enter a unique image name.</small>
    </div>
    <div class="form-group">
        <label for="fileInput">Choose File</label>
        <input type="file" class="form-control-file" id="fileInput" name="file">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="checkForDuplicates()">Upload</button>
    </div>
</form>