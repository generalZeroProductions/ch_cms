@php
    $width = Session::get('screenwidth') / 4.9;
    $height = 220;
    if ($style === 'rounded-circle') {
        $height = $width;
    }
    echo '<style>  .image-crop {
        width:' .
        $width .
        'px;
        height:' .
        $height .
        'px;
        object-fit: cover;
        margin-top: 8px;
        margin-bottom: 18px;
    }
 
</style>';
    $localImage = 'image-crop ' . $style;
@endphp

<div id = "fileContainer">
    <img src = "{{ asset('images/defaultImage.jpg') }}" class="{{ $localImage }}" id = "thumb">
</div>
<div id="spinnerContainer" style="display: none;">
    <!-- Spinning/waiting element -->
    <div class="spinner"></div>
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

    .image-thumb-rounded {
        border-radius: 15px;
    }

    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: auto;
        margin-top: 20px;
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
