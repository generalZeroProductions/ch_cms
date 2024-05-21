@php
use Illuminate\Support\Facades\Log;
$style = $column->styles['corners'];
$width = Session::get('screenwidth')/5.5;
$height = 220;
if($style==='rounded-circle'){
    $height=$width;
}
echo '<style>  .image-crop {
        width:'.$width.'px;
        height:'.$height.'px;
        object-fit: cover;
        margin-top: 8px;
        margin-bottom: 8px;
    }</style>';
    $localImage = 'image-crop ' . $column->styles['corners'];
    $divId = 'image_' . $rowId;
    $captionAt = 'end';
    if( $column->styles['corners']==='hi')
    {
        $captionAt= 'center';
    }
    $item = json_encode(['pageId'=> $pageId, 'rowId'=>$rowId, 'column' =>$column]); 
@endphp

<div id={{ $divId }}>
    @if ($editMode && !$tabContent)
        <div class="d-flex align-items-center image-icon-space hide-editor">
            <a href="#" onClick="insertForm('img_edit^{{$column->id}}', '{{ $item }}', '{{ $divId }}' )">
                <img src="{{ asset('icons/pen.svg') }}" class="image-pen-icon">
            </a>
        </div>
    @endif
    <div style = "padding-top: 12px;">
        <img src="{{ asset('images/' . $column->image) }}" class="{{ $localImage }}">
    </div>
    <div class = "d-flex justify-content-{{$captionAt}}" style="padding-right:8px">
        <figcaption>{{ $column->body }}</figcaption>
    </div>

</div>


