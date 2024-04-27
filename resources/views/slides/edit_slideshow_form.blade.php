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

<form method="POST" action="update_slideshow" enctype="multipart/form-data" id="slideEditForm">
    @csrf
    <div class="form-group">
        <div class = "row row-of-slides" id = "preview_list" style = "margin:24px">
            @for ($i = 0; $i < 6; $i++)
                @if ($i === 3)
        </div>
        <div class = "row row-of-slides" id = "preview_list" style = "margin:24px">
            @endif
            <div class="col-md-4 col-slide-preview" id="preview_{{ $i }}">
                <div class = "row parent" id="file_input_{{ $i }}">
                <div class = 'child'>
                    <input type="file" class="form-control-file" id="file_capture_{{ $i }}" name="file_input_{{ $i }}" style="width:28vh">
                    </div>
                     <div class = 'child'>
                        <a href="#" onClick ="showEditElement({{ $i }})"><img
                                src="{{ asset('icons/close.svg') }}" class= 'slide_edit_icon'></a>
                    </div>
                </div>
                <div class = "row parent" id="image_select_{{ $i }}">
                    <div class = 'child'>
                        <select name="image_select_{{ $i }}" class="form-control" id="image_capture_{{$i}}" style="width:28vh">
                            @foreach ($imageNames as $imageName)
                                <option value="{{ $imageName }}">{{ $imageName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class = 'child'>
                        <a href="#" onClick ="showEditElement({{ $i }})"><img
                                src="{{ asset('icons/close.svg') }}" class= 'slide_edit_icon'></a>
                    </div>
                </div>
                <div class = "row" id="edit_icons_{{ $i }}">
                    <a href="#" onClick= "deleteItemAtIndex({{$i}})">
                        <div class="tooltip-text-slideshow" id = "tooltip_trash{{ $i }}"> delete this
                            slide</div><img src="{{ asset('icons/trash.svg') }}" id="trash_icon_{{ $i }}"
                            class= "slide_edit_icon ">
                    </a>
                    <a href="#" onClick= "showSelectElement({{ $i }})">
                        <img src="{{ asset('icons/file.svg') }}" id="file_icon_{{ $i }}"
                            class= "image-fluid slide_edit_icon ">
                            <div class="tooltip-text-slideshow" id = "tooltip_file{{ $i }}"> get file from
                            server</div>
                    </a>
                    <a href="#" onClick= "showUploadElement({{ $i }})">
                        <div class="tooltip-text-slideshow" id = "tooltip_upload{{ $i }}"> upload file
                        </div><img src="{{ asset('icons/upload2.svg') }}" id="upload_icon_{{ $i }}"
                            class= "slide_edit_icon ">
                    </a>
                </div>
                <div class="row image-slide-thumb" id="thumb_{{ $i }}">
                    <img src="{{ asset('images\lake.jpg') }}" class="img-fluid">
                </div>
                <div class="row add_thumbnail" id="add_{{ $i }}">
                    <a href="#" onClick="createNewSlide(null)" class="centered">
                        <img src="{{ asset('icons\add.svg') }}" class="svg">
                    </a>
                </div>
                <div class="row" id="caption_{{ $i }}">
                    <input class = "text-box-slide-caption" id="caption_capture{{ $i }}" type="text" name = "caption_{{ $i }}" autocomplete="off">
                </div>

            </div>

            @endfor
        </div>
    </div>
    <div class="row justify-content-end align-items-end" style = "margin-right:10px">
        <button type="submit" class="btn btn-primary">
            保存幻灯片
        </button>
    </div>
    </div>
    <input type="hidden" id="slide_show_data" name="data">
    <input type="hidden" id="row_id" name="row_id">
    <input type="hidden" id="page_id" name="page_id">
</form>



<div id = "run_scripts">
    <script>
        toolTipStart();
    </script>
</div>
