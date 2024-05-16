@php

    $imageNames = [];
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $imageNames[] = pathinfo($file, PATHINFO_BASENAME);
        }
    }
   

@endphp

<div style="padding-top:24px">

    <form method="POST" enctype="multipart/form-data" id="img_edit">
        @csrf
        @include('images.partials.file_icons_2')
        <div id = "upload_file_bar">
            <input type="file" class="form-control file-select-bar" id="upload" name='upload_file'>
        </div>
        <div id="server_file_bar">
            <select class= "form-control file-select-bar" id="server" name = "server_file">
                <option value="选择一个文件...">选择一个文件...</option>
                @foreach ($imageNames as $imageName)
                    <option value="{{ $imageName }}">{{ $imageName }}</option>
                @endforeach
            </select>
            </select>
        </div>
        <div class="stack-icons">
            @include('images.partials.image_preview', ['style' => $style])

            @include('images.partials.corners_select')
        </div>
        <label class = 'form-label-sm'>图片标题</label>

        <input class="form-control site-text-input" type = "text" id="caption" name="caption" autocomplete="off">
        <input type="hidden" name="image_name" id = "image_name">
        <input type="hidden" name="row_id" id = "row_id">
        <input type="hidden" name="column_id" id = "column_id">
        <input type="hidden" name="corners" id = "corners_field">
        <input type = 'hidden' name = "form_name" value = "img_edit">
    </form>
    <div class = "d-flex justify-content-end under-right">
        <button type="submit" class="btn btn-primary site-save-btn" id = 'img_edit_btn'>
            <img src= '{{ asset('icons/save.svg') }}'>
        </button>
    </div>
</div>


<style>

    .site-text-input {
        border-color: darkslategrey;
        height: 36px;
        font-size: 16;
    }



    .under-right {
        margin-top: 12px;
    }

    .form-label-sm {
        font-size: 12px;
        font-weight: 800;
    }

    .select-corners {
        height: 22px;
    }

    .file-select-bar {
        padding-left: 0px !important;
        height: 36px !important;
        border: none;
    }
</style>
