@if ($editMode)
    <div class = "row">
        <a href="#" class="nav-link"
            onClick="openBaseModal('uploadImage',null, '{{ json_encode($column) }}','{{ $pageName }}')">
            <span class="menu-icon"><img src="{{ asset('icons/pen.svg') }}"></span>
        </a>
    </div>
@endif
<img src="{{ asset('images/' . $column->image) }}" class="img-fluid" style="width: 100%;">
