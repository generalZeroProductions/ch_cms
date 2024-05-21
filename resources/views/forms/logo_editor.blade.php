@php
    use Illuminate\Support\Facades\Storage;
    $directory = 'public/images';
    $files = Storage::allFiles($directory);
    $imageNames = [];
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $imageNames[] = pathinfo($file, PATHINFO_BASENAME);
        }
    }
    $showLogo = $logo->data['image'];
    $showTitle = $logo->data['title'];
@endphp

<div class = "container-fluid logo-block" style="margin:0px !important">


    <form id = "logo_edit">
        @csrf
        <div class = "row d-flex">

            <div class = "toggle" style = "margin-left:20px;">
                <div class="custom-control custom-switch" name="use_logo">
                    <input type="checkbox" class="custom-control-input" id="logoToggle" <?php echo $showLogo ? 'checked' : ''; ?>
                        name="use_logo">
                    <label class="custom-control-label" for="logoToggle">形象标识</label>
                </div>
                <div id = "logo_thumb">
                    <img src = "{{ asset('images/' . $logo->route) }}" class="logo-crop" id ="thumb">
                </div>
                <div id="spinnerContainer" style="display: none;">
                    <!-- Spinning/waiting element -->
                    <div class="spinner"></div>
                </div>

            </div>

            <div style= "margin-left:10px;" id="logo_upload_ctls">
                <div>
                    <a id="upload_anchor_logo"><img src="{{ asset('icons/upload_green.svg') }}" class= "file-icon-logo"
                            id="upload_icon_logo"></a>
                    <a id="server_anchor_logo" style="cursor:pointer"><img src="{{ asset('icons/server.svg') }}"
                            class= "file-icon-logo" id="server_icon_logo"></a>
                </div>
                <div id = "upload_file_bar_logo" style= "width:210px !important;">
                    <input type="file" class="form-control file-select-bar" id="upload_logo" name='upload_file'>
                </div>
                <div id="server_file_bar_logo">
                    <select class= "form-control file-select-bar" id="server_logo" name = "server_file"
                        style= "width:210px !important;">
                        <option value="选择一个文件...">选择一个文件...</option>
                        @foreach ($imageNames as $imageName)
                            <option value="{{ $imageName }}">{{ $imageName }}</option>
                        @endforeach
                    </select>
                    </select>
                </div>
              
            </div>
           
            <input type="hidden" name = "title" id="send_logo_title" value="{{ $logo->title }}">
            <input type="hidden" name = "form_name" value="logo_edit">
            <input type="hidden" name = "from_server" value='0' id="logo_from_server">
            <input type = "hidden" name = "image_name" id = "logo_image_name" value="{{ $logo->route }}">
    </form>
    <div style= "height:34px; background-color:red"></div>  
    <div class = "title-col" style = "margin-left:20px;">
       
        <div class="custom-control custom-switch" name = "use_title">
            <input type="checkbox" class="custom-control-input" id="title_Toggle" <?php echo $showTitle ? 'checked' : ''; ?>
                name = "use_title">
            <label id = "logo_title" class="custom-control-label" for="title_Toggle">标志文字</label>
        </div>
        <input type= "text" class = " logo-h3" value = "{{ $logo->title }}" id ="logo_text" name="title">
    </div>
    <button onClick="submitLogoChange()" class = "btn btn-primary save_logo_btn disabled" id ="save_logo_btn">
        <img src = "{{ asset('/icons/save.svg') }}" class="save_icon_logo">
    </button>
</div>


</div>


<style>
    .save_icon_logo {
        height: 34px;
    }

    .logo-h3 {
        margin-top: 11px;
        height: 52px;
        font-size: 20px;
        font-weight: 500;
    }

    .logo-block {
        display: block;
    }

    .show-logo-element {
        visibility: visible;
    }

    .hide-logo-element {
        visibility: hidden;
    }

    .show-logo-block {
        display: block;
    }

    .hide-logo-block {
        display: none;
    }

    .caption-input {
        width: 100% !important;
    }

    .file-icon-logo {
        height: 30px;
        margin-bottom: 10px;
        margin-top: 6px;
    }

    .image-control-bar {
        height: 50px;
        padding: 0 !important;
        align-items: center !important;
    }

    .logo-thumb {
        height: 64px;
        margin-top: 4px;
        margin-bottom: 4px;
    }

    .toggle {
        padding-top: 0px;
        margin-right: 12px;
    }

    .logo-crop {
        width: auto;
        height: 64px;
        object-fit: cover;
    }

    .save_logo_btn {
        height: 42px;
        width: 44px;
        margin-top: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4px !important;
        border: none;
        cursor: default;
        margin-left: 12px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
