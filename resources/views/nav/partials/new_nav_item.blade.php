@php
    $divId = 'add_at' . $nav->index;
@endphp
<li class="nav-item add-nav-div" id = "{{ $divId }}">
    <div class="d-flex align-items-center ">
        |
        <a href = "#" id="add_nav_anchor" class="nav-link"
            onClick = "insertForm('{{ json_encode($nav) }}', 'nav_add', '{{ $divId }}')">

            <img src = "{{ asset('icons\add.svg') }}" class="add-nav-icon">

        </a>
        |
    </div>
</li>
<style>
    .add-nav-div {
        padding-top: 9px;
        margin-right: 6px;
    }

    .add-nav-icon {
        margin-top:3px;
        height: 18px;
    }
</style>
