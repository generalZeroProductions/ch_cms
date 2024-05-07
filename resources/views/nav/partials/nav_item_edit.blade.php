@php
    $jNav = json_encode($nav);
    $divId = $nav->id .'_'.$nav->title ;

@endphp
<li id = "{{ $divId }}">
    <div class="d-flex justify-content-start mb-3">
        <div class="p-2 nav-item {{ $key === 0 ? 'active' : '' }}">
            <a href="#" class="nav-link" onClick="loadPageFromNav('{{ $nav->route }}')">
                {{ $nav->title }}
            </a>
        </div>
        <div class="p-2 ">
            <a href="#" onClick = "insertForm('{{ json_encode($nav) }}', 'nav_standard', '{{ $divId }}', '{{$key}}')">
                <img src={{ asset('icons/pen.svg') }} class="edit-nav-pen"></a>
        </div>
        @if ($canDelete)
            <div class="p-2 ">
                <a href = "#"
                    onClick = "insertForm('{{ json_encode($nav) }}', 'nav_delete', '{{ $divId }}', '{{$key}}')">
                    <img src={{ asset('icons/trash.svg') }} class = "edit-nav-trash"></a>
            </div>
        @endif
        <div class="flex-grow-1 p-2"></div>
    </div>
</li>


<style>
    .p-2 {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }

    .edit-nav-pen {
        height: 20px;
        margin-right: 6px;
        margin-top: 10px;
    }

    .edit-nav-trash {
        height: 20px;
        margin-right: 6px;
        margin-top: 10px;
    }
</style>
