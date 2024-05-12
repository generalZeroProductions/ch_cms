@php

    $localImage = 'image-crop ' . $column->styles['corners'] .' image-thumb';
    $divId = 'image_' . $rowId;
@endphp

<div id={{ $divId }}>
    @if ($editMode && !$tabContent)
        <div class="d-flex align-items-center icon-space">
            <a href="#" onClick="insertForm('img_edit', '{{ $column }}', '{{ $divId }}' )">
                <img src="{{ asset('icons/pen.svg') }}" class="pen-icon">
            </a>
        </div>
    @endif
    <div style = "padding-top: 12px;">
        <img src="{{ asset('images/' . $column->image) }}" class="{{ $localImage }}">
    </div>
    <div class = "d-flex justify-content-end" style="padding-right:8px">
        <figcaption>{{ $column->body }}</figcaption>
    </div>

</div>

<style>
    .pen-icon {
        margin-left: 10px;
        height: 18px
    }

    .icon-space {
        height: 48px;
    }

    .image-thumb {
        height: 160px;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .image-thumb-rounded {
        border-radius: 15px;
    }

    .image-crop {
        width: 220px;
        height: 220px;
        object-fit: cover;
    }
</style>
