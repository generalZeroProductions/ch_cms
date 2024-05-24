@php
    $divId = 'add_at' . $nav->index;
    $item = $nav->index;
@endphp
<li class="nav-item adder d-flex justify-content-center adder-narrow" id = "{{ $divId }}">
    <a style= "cursor: pointer;" id="add_nav_anchor" class="nav-link hide-editor-nav"
        onClick = "insertForm('add_nav', '{{ $item }}' ,  '{{ $divId }}')">
        <img src = "{{ asset('icons\add_nav.svg') }}" class="add-nav-icon">
    </a>

</li>
<style>
    .add-nav-icon {
        margin-top: 12px;
        margin-right: 0px !important;
        height: 18px;
    }

    .adder-narrow {
        width: 60px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

       .adder-wide {
        width: 200px !important;
        padding-right: 10px !important;
        margin-right:30px;
    }
</style>
