@php
    use Illuminate\Support\Facades\Log;
    Log::info('@slideshow');
    if (Session::has('screenwidth')) {
        echo "<style>
        .banner_container {
            width:100%;
            height: " .
            $slideHeight .
            "px;
            overflow: hidden; /* Ensure that the image is cropped to fit within the container */
        }
        .banner_container img {
            width: 100%; /* Make the image fill the width of the container */
            height: 100%; /* Make the image fill the height of the container */
            object-fit: cover; /* Crop the image to cover the container */
        }
    </style>";
    }

    $index = 0;
    $slideBox = 'slide_box_' . $rowId;
    $slideshowId = 'slide_show_' . $rowId;

@endphp



{{-- 
@if (count($slideList) > 0)

  --}}  <div id="{{ $slideBox }}"> 
        @if (count($slideList) > 1)
@include('slides.slide_carousel',['slideList'=>$slideList,'slideshowId'=>$slideshowId])
   
@else
    <div class = 'banner_container'>
        <img src ="{{ asset('images/' . $slideList[0]['image']) }} " class = "image-fluid">
    </div>
@endif{{--
@endif  --}}
@if ($editMode && !$tabContent)
    @include('slides.forms.edit_slides_bar', [
        'slideBox' => $slideBox, 
        'pageId' => $pageId,
        'rowId'=>$rowId,
        'slideJson' => $slideJson,
    ])
@endif

</div> 
