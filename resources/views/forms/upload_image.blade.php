@php
    use Illuminate\Support\Facades\Storage;
    $directory = 'public/images'; // Adjust the directory path as per your setup
    $files = Storage::allFiles($directory);
    $imageNames = [];
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $imageNames[] = pathinfo($file, PATHINFO_BASENAME);
        }
    }

@endphp
<div class = "container" style="padding-left:0px">
<form method="POST" action="/upload" enctype="multipart/form-data">
    @csrf
    <div class="form-group form-section-header">
        <label for="fileInput">上传新图像文件</label>
        <div class=row>
            <div class=col-md-9>
                <input type="file" class="form-control-file" id="fileInput" name="file" value="选择图像" placeholder="选择图像">
            </div>
            <div class=col-md-3 style = "justify-content: left">
                <button type="submit" class="btn btn-primary" style = "text-align:center;width: 110px;">上传并使用</button>
            </div>
        </div>
    </div>

    <input type = "hidden" id="page_id" name ="page_id">
    <input type = "hidden" id = "column_id" name = "column_id">
</form>
<hr>
<form method="POST" action="/use_image">
    @csrf
    <div class="form-group form-section-header">
        <label for="fileInput">使用来自服务器的图像文件</label>
          <div class=row>
            <div class=col-md-9>
                <select id="image_select" name="image_select" class="form-control col new_item_input">
            @foreach ($imageNames as $imageName)
                <option value="{{ $imageName }}">{{ $imageName }}</option>
            @endforeach
        </select>
            </div>
            <div class=col-md-3 style = "justify-content: left">
            <button type="submit" class="btn btn-primary" style = "text-align:center; width: 110px;">使用图像</button>
            </div>
        </div>
    </div>
    <input type = "hidden" id= "page_id_at_select" name ="page_id_at_select">
    <input type = "hidden" id = "column_id_select" name = "column_id_select">
</form>
</div>
