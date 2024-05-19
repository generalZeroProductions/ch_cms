@php

    $jNav = json_encode(['nav' => $nav, 'key' => $nav->index]);
    $divId = $nav->id . '_' . $nav->title;
    $navKey = Session::get('navKey');
@endphp
<li id = "{{ $divId }}">
    <div class="d-flex justify-content-start mb-3">
        @if ($navKey === $nav->index)
            <div class="p-2 nav-item active">
            @else
                <div class="p-2 nav-item">
        @endif
            <a href="{{ $nav->route }}" class="nav-link">
                    {{ $nav->title }}
                    </a>
                </div>
                <div class="p-2 ">
                    <a style= "cursor: pointer;"
                        onClick = "insertForm('edit_nav','{{ $jNav }}',  '{{ $divId }}')">
                        <img src={{ asset('icons/pen.svg') }} class="edit-nav-pen"></a>
                </div>
                @if ($canDelete)
                    <div class="p-2 ">
                        <a style= "cursor: pointer;"
                            onClick = "insertForm('nav_delete','{{ $jNav }}', '{{ $divId }}')">
                            <img src={{ asset('icons/trash.svg') }} class = "edit-nav-trash"></a>
                    </div>
                @endif
                <div class="flex-grow-1 p-2"></div>
            </div>
</li>


<style>
    .adder {
        width: 16px !important;
    }

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
