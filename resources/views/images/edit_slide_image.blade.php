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
<div>
    <div class="form-group form-section-header">
        <label for="fileInput">上传新图像文件</label>
        <div class=row>
            <div class=col-md-9>
                <input type="file" class="form-control-file" id="fileInput" name="file">
            </div>
            <div class=col-md-3 style = "justify-content: left">
                <button class="btn btn-primary" onClick = "refreshSlideImage('upload')" style = "text-align:center;width: 110px;">上传并使用</button>
            </div>
        </div>
    </div>
</div>
<hr>
<div >
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
            <button class="btn btn-primary" onClick = "refreshSlideImage('image')" style = "text-align:center; width: 110px;">使用图像</button>
            </div>
        </div>
    </div>
  
</div>
</div>
