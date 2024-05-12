
@php

@endphp

<div class = "image-thumb" >
    <img src = "{{ asset('images/lake.jpg') }}" class="image-crop-editor img-fluid" id = "thumb">
</div>



<style>
    .caption-input {
        width: 100% !important;
    }

    .image-thumb {
        height: 160px;
        margin-top: 8px;
        margin-bottom: 8px;
    }
.image-thumb-rounded{
    border-radius: 15px;
}

    .image-crop-editor {
        width: auto;
        height: 220px;
        object-fit: cover;
        margin-bottom:8px !important;
    }
</style>
