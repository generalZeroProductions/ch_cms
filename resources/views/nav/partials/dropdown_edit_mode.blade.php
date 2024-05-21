@php
    use Illuminate\Support\Facades\Log;
    $jNav = json_encode($nav);
    $jDrop = json_encode(['nav' => $nav, 'sub' => $subs, 'key' => $nav->index]);
    $divId = $nav->id . '_' . $nav->title;
    $navKey = Session::get('navKey');
@endphp

<li class="nav-item dropdown " id = "{{ $divId }}">
    <div class="d-flex justify-content-start mb-3 ">

        @if ($navKey === $nav->index)
            <div class="p-2 nav-item active">
            @else
                <div class="p-2 nav-item">
        @endif

        <a class="nav-link dropdown-toggle" href="/{{ $nav->route }}" id="{{ $nav->title }}Dropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $nav->title }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach ($subs as $subNav)
                <a class="dropdown-item"href="/{{ $subNav->route }}">{{ $subNav->title }}</a>
            @endforeach
        </div>
    </div>
    <div class="p-2 hide-editor">
        <a style= "cursor: pointer;" class="hide-editor"
            onClick = "insertForm('dropdown_editor_nav','{{ $jDrop }}',  '{{ $divId }}')">
            <img src={{ asset('icons/pen.svg') }} class="edit-nav-pen"></a>
    </div>
    <div class="p-2 hide-editor">
        <a style= "cursor: pointer;" class="hide-editor"
            onClick = "insertForm( 'nav_delete','{{ $jNav }}', '{{ $divId }}')">
            <img src={{ asset('icons/trash.svg') }} class = "edit-nav-trash"></a>
    </div>
    </div>
</li>


<style>
    .p-2-nav {
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

    .p-2-icon {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
</style>
