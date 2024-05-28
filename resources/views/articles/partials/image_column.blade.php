@php
use Illuminate\Support\Facades\Session;
$style = $column->styles['corners'];
$width = Session::get('screenwidth')*.55;
$width = $width * 0.333;

$height = 220;

if ($tabContent) {
    $width = $width * 0.8;
}
$padCaption = $width * 0.1;
$captionAt = 'end';
if ($style === 'rounded-circle') {
    $height = $width;
    Log::info('height being set to ' . $height);
    $captionAt = 'center';
   
}
 $padCaption = (int) $padCaption;
$height=$height*0.9;
$height = (int)$height;

$uniqueClass = uniqid('image-crop-');
echo '<style>
    .' . $uniqueClass . ' {
        width: 90%;
        height: ' . $height . 'px;
        object-fit: cover;
        margin-top: 8px;
        margin-bottom: 8px;
    }</style>';
    $localImage = $uniqueClass.' '. $column->styles['corners'];
    $divId = 'image_' . $rowId;
    $item = json_encode(['pageId'=> $pageId, 'rowId'=>$rowId, 'column' =>$column]); 
@endphp

<div id={{ $divId }}>
    @if ($editMode && !$tabContent)
        <div class="d-flex align-items-center image-icon-space hide-editor">
            <a style="cursor:pointer" onClick="insertForm('img_edit^{{$column->id}}', '{{ $item }}', '{{ $divId }}' )">
                <img src="{{ asset('icons/pen.svg') }}" class="image-pen-icon">
            </a>
        </div>
    @endif
    <div style = "padding-top: 12px;">
        <img src="{{ asset('images/' . $column->image) }}" class="{{ $localImage }}">
    </div>
   <div class = "d-flex justify-content-{{$captionAt}}" style="padding-right:{{$padCaption}}px">
        <figcaption>{{ $column->body }}</figcaption>
    </div>
@php

@endphp
</div>


