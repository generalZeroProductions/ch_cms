<div>
    @if ($editMode && !$tabContent)
        <div class="d-flex align-items-center icon-space">
            <a href="#"
                onClick="openMainModal('uploadImage','{{ json_encode($column) }}','{{ json_encode($location) }}')">
                <span ><img src="{{ asset('icons/pen.svg') }}" class="pen-icon"></span>
            </a>
        </div>
    @endif
    <div style = "padding-top: 12px;">
        <img src="{{ asset('images/' . $column->image) }}" class="img-fluid">
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
</style>
