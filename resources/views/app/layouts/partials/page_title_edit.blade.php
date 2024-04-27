@php
    $linkId = $location['page']['title'] . '_' . $location['page']['id'];
@endphp


<div class="container-fluid blue_row">
    <div class="row">
        <div class="col-md-10" id = "{{ $linkId }}">
                <div class = "row top-left-edits">
                    <a href="#"  style=" text-decoration: none;" onClick="changePageTitle('{{ json_encode($location) }}','{{ $linkId }}')"
                        class="d-flex align-items-center">
                        <!-- Text -->
                        <p class="title-indicator">页面名称:</p>
                        <p class="title_reference">{{ $location['page']['title'] }}</p>
                        <!-- Image -->
                        <img src="{{ asset('icons/pen_white.svg') }}" class="space_icon_right-sm">
                    </a>
                </div>
        </div>
    </div>
</div>
<br>


