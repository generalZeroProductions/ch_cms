<?php
if (isset($_SESSION['screenWidth'])) {
    echo "<style>
        .banner_container {
            width: " .
        $_SESSION['screenWidth'] .
        "px;
            height: " .
        $_SESSION['screenWidth'] / 3 .
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
use App\Models\ContentItem;

$slideData = $location['row']['data']['slides'];

$slideList = [];
$slideJson = [];
foreach ($slideData as $slideId) {
    $slide = ContentItem::findOrFail($slideId);
    $jSlide = [
        'image' => $slide->image,
        'caption' => $slide->title,
        'record' => $slide->id,
    ];
    $slideJson[] = $jSlide;
    $slideList[] = $slide;
}

$index = 0;
$editMode = true;
$slideBox = 'slide_box_' . $location['row']['id'];
$slideshowId = 'slide_show_' . $location['row']['id'];

?>
<div class="row title_change_div">
    @include('/rows/page_title_edit', ['location' => $location])
</div>

@if (count($slideList) > 0)
    <div id="{{ $slideBox }}">
        @if ($editMode)
            <div class="row title_change_div">
                <div class="col-md-10" id = "{{ $location['row']['id'] }}">
                    <p class = "title_indicator"> Edit Slideshow</p>
                    <a href="#"
                        onClick = "editSlidesForm('{{ $slideBox }}','{{ json_encode($location) }}', '{{ json_encode($slideJson) }}')">
                        <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                    </a>
                </div>
                <div class = "col-md-2 delete_row_button">
                    @include('rows/delete_row_button')
                </div>
            </div>
        @endif
        @if (count($slideList) > 1)

            <div class="carousel slide" data-ride="carousel" id = "{{ $slideshowId }}">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    @foreach ($slideList as $slide)
                        @if ($index === 0)
                            <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}" class="active">
                            </li>
                        @else
                            <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}1"></li>
                        @endif
                        @php
                            $index += 1;
                        @endphp
                    @endforeach

                </ul>
                @php
                    $index = 0;
                @endphp
                <!-- The slideshow -->
                <div class="carousel-inner">
                    @foreach ($slideList as $slide)
                        @if ($index === 0)
                            <div class="carousel-item banner_container active">
                            @else
                                <div class="carousel-item banner_container">
                        @endif
                        <img src ="{{ asset('images/' . $slide->image) }} " class = "image-fluid">
                </div>
                @php
                    $index += 1;
                @endphp
        @endforeach
   
    <a class="carousel-control-prev" href="#{{ $slideshowId }}" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#{{ $slideshowId }}" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
    </div>
    </div>
@else
<div class = 'banner_container'>
    <img src ="{{ asset('images/' . $slideList[0]['image']) }} " class = "image-fluid">
    </div>
    </div>

@endif
@endif
<div class="row row_add_button">
    @include('rows/add_row_button', ['location' => $location])

</div>


</div>
