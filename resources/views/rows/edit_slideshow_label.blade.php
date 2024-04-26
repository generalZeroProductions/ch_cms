@php
    $linkId = 1;
@endphp

{{-- <div class="container-fluid blue_row">
    <div class="row">
        <div class="col-md-10" id = "{{ $linkId }}">
            <div class = "row top-left-edits">
                <a href="#" style=" text-decoration: none;"
                    onClick = "editSlidesForm('{{ $slideBox }}','{{ json_encode($location) }}', '{{ json_encode($slideJson) }}')">
                    <div class = "row top-left-edits">
                        <p class="title-indicator"> Edit Slideshow</p> <img src="{{ asset('icons/pen_white.svg') }}"
                            class = 'space_icon_right-sm'>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>
<br> --}}


<div class="container-fluid green_row">
    <div class="row">
        <div class = 'col-lg-5 col-sm-0 col-white'></div>
        <div class="col-lg-2 col-sm-12 d-flex justify-content-center" id = "{{ $linkId }}">
            <div class = "row row-middle-edits">
                <a href="#" style=" text-decoration: none;"
                    onClick = "editSlidesForm('{{ $slideBox }}','{{ json_encode($location) }}', '{{ json_encode($slideJson) }}')"
                    class="d-flex align-items-center">
                    <!-- Text -->
                    <p class="title-indicator">编辑幻灯片:</p>
                    <!-- Image -->
                    <img src="{{ asset('icons/pen_white.svg') }}" class="space_icon_right-sm">
                </a>
            </div>
        </div>
        <div class = 'col-lg-5 col-sm-0 col-white'></div>
    </div>
</div>
<br>
