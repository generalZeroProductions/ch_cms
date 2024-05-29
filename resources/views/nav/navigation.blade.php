@php
$mobile = false;
if(Session::has('mobile'))
{
    $mobile = Session::get('mobile');
}
@endphp


@if (Auth::check())
    @include('app.edit_mode.edit_mode_banner',['logo'=>$logo])
    @if (!$buildMode)
        @include('nav.nav', ['canDelete' => $canDelete,'logo'=>$logo])
    @endif
@else
    @include('nav.nav', ['canDelete' => $canDelete,'logo'=>$logo])
@endif


@if (!$editMode && !$mobile)
    <style>
        .navbar {
            padding-right: 40px !important;
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
