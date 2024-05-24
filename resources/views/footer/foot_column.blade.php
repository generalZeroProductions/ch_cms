@php
    $editMode = Session::get('editMode');
    $jItem = json_encode(['items'=>$items, 'divId'=>$divId]);
@endphp


@if ($editMode)
    <div class="col d-flex align-items-center article-icon-space hide-editor">
        <a style= "cursor: pointer;" onClick = "insertForm('edit_footer_item','{{ $jItem }}','{{ $divId }}')">
            <img src="{{ asset('icons/pen.svg') }}" class="article-pen-icon">
        </a>
    </div>
@endif
@foreach ($items as $item)
<div >
<p >
@php
 echo htmlspecialchars_decode($item->body)
@endphp
</p>

</div>
@endforeach
<style>
.footer-line{

    height:10px;
}
</style>