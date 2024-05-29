@php
    use Illuminate\Support\Facades\Log;
    $imgWidth = Session::get('screenwidth');
    if (Session::has('screenwidth')) {
       echo "<style>
    .banner_container {
        width: 100%;
        height: {$slideHeight}px;
        overflow: hidden;
        position: relative; /* Parent container with relative position */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .banner_container img {
        width: 100%;
        height: auto;
        position: absolute; /* Absolutely positioned to center */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      
    }
    </style>";

    }

    $index = 0;
    $slideBox = 'slide_box_' . $rowId;
    $slideshowId = 'slide_show_' . $rowId;

@endphp
<div id="{{ $slideBox }}">
    @if (count($slideList) > 1)
        @include('slides.slide_carousel', ['slideList' => $slideList, 'slideshowId' => $slideshowId])
    @else
        <div class = 'banner_container'>
            <img src ="{{ asset('images/' . $slideList[0]['image']) }}" class =  "banner-container-img">
        </div>
    @endif
    @if ($editMode && !$tabContent)
        @include('slides.forms.edit_slides_bar', [
            'slideBox' => $slideBox,
            'pageId' => $pageId,
            'rowId' => $rowId,
            'slideJson' => $slideJson,
        ])
    @endif
</div>
