<div class="card-body">
    <div class="image-control-bar" id="edit_icons">
        {{-- edit icons fit here. --}}
    </div>
    <div class = "image-thumb" id = "thumb">
        <img src = "{{ asset('images/lake.jpg') }}" class="image-crop">
    </div>
    <input class="form-control caption-input" type = "text" id="caption">
</div>


<style>
    .caption-input {
        width: 100% !important;
    }

    .image-control-bar {
        height: 50px;
        padding: 0 !important;
        align-items: center !important;
    }

    .image-thumb {
        height: 160px;
        margin-top: 4px;
        margin-bottom: 4px;
    }

    .image-crop {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
</style>