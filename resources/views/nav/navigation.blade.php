@if (Auth::check())
    @include('app/layouts/partials/edit_mode_banner')
    @if (!$buildMode)
        @include('nav.nav', ['canDelete' => $canDelete])
    @endif
@else
    @include('nav.nav', ['canDelete' => $canDelete])
@endif


@if (!$editMode)
    <style>
        .navbar {
            padding-right: 80px !important;
        }
    </style>
@endif

<style>
    .nav-fixed-top {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: #ffffff;
        z-index: 1000;
    }
</style>
