@php
    $linkId = $location['page']['title'] . '_' . $location['page']['id'];
@endphp


<div class="container-fluid blue-green-row">
    <div class="row">
        <div class="col-md-12" id = "{{ $linkId }}">
                <div class = "row top-right-edits justify-content-end">
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


<style>

.blue-green-row {
    background-color: rgb(42, 199, 181);
    height: 44px;
    margin-top:12px;
}
</style>