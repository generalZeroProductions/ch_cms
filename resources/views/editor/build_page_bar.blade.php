@php

    $id = $location['page']['id'];
    $loc = $location['page']['title'];
@endphp

<style>
    .gray-row {
        margin-top: 10px;
        background-color: gray;
        height: 48px;
    }

    .btn-44-build {
        height: 44px;
        font-size: medium;
        font-weight: 600;
        width:120;
    }
    .build-icon{
        height:22px;
        margin-left:4px;
        margin-bottom:2px;
    }
</style>

<div class="d-flex gray-row">
    <div class="col-9">
    </div>
    <div class="col-3 d-flex justify-content-end align-items-center">
        <button class = "btn btn-secondary btn-44-build"
            onClick="enterPageBuild('{{$loc}}','build')">
            建立页面 <img src={{ asset('icons/build.svg') }} class="build-icon"></button>
    </div>
</div>
