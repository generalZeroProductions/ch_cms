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
    <div class="form-group" style = "margin:20px">
        <div class = "row" id = "preview_list">
            @for ($i = 0; $i < 6; $i++)
                <div class="col-md-2 slide-preview" id="preview_{{ $i }}" style="margin:8px">
                    <div id = "slide_detail_{{ $i }}">
                        <input type="file" class="form-control-file" id="file_input_{{ $i }}"
                            name="file_input_{{ $i }}">
                        <select id="image_select_{{ $i }}" name="image_select_{{ $i }}"
                            class="form-control col new_item_input">
                            @foreach ($imageNames as $imageName)
                                <option value="{{ $imageName }}">{{ $imageName }}</option>
                            @endforeach
                        </select>

                        <div class="row slide_thumbnail">
                            <div id="add_{{ $i }}">
                                <a href="#" onClick="createNewSlide(null)">
                                    <img src="{{ asset('icons\add.svg') }}">
                                </a>
                            </div>
                            <div id="thumb_{{ $i }}">
                                <img src="{{ asset('images\lake.jpg') }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="row">
                            <input type="text" id="caption_{{ $i }}">
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div class="row justify-content-end align-items-end" style = "margin-right:10px">
        <a href="#" onClick="printFieldData()"> PRINT</a>
        <button type="submit" class="btn btn-primary">
            保存幻灯片
        </button>
    </div>
    </div>
    <input type="hidden" id="slideshowData" name="data">
    <input type="hidden" id="row_id" name="row_id">
    <input type="hidden" id="page_name" name="page_name">
</form>
