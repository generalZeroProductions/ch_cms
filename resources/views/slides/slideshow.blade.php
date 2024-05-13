@php
if (Session::has('screenwidth')) {
    echo "<style>
        .banner_container {
            width: " .
        Session::get('screenwidth') .
        "px;
            height: " .
        Session::get('screenwidth') / 3 .
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


@if (count($slideList) > 0)

    <div id="{{ $slideBox }}">
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
                        <div class="carousel-caption d-none d-md-block">
                            <h2>{{ $slide->body }}</h2>
                        </div>
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
@endif
@endif
</div>
</div>