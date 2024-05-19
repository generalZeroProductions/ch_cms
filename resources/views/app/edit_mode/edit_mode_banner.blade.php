@php
    $loc = Session::get('location');
    $returnLoc;
    $editMode = Session::get('editMode');
    if (Session::has('returnPage')) {
        if (Session::get('returnPage') !== '') {
            $returnLoc = Session::get('returnPage');
        } else {
            $returnLoc = $loc;
        }
    }

@endphp
@include('app.edit_mode.auth_on_off')
<?php

echo 'return = ' . Session::get('returnPage') . '///    tab = ' . Session::get('tabId') . '/// build =' . Session::get('buildMode') . '///edit = ' . Session::get('editMode') . '///screen =' . Session::get('screenwidth') . '///scroll =' . Session::get('scrollTo') . '///key =' . Session::get('navKey');
?>

<div class ='edit-container ' id = "edit_mode_contain">
    <div class="row d-flex justify-content-end align-items-center rounded-box">
        <div class=col-7>
            @if ($editMode)
                @include('forms.logo_editor')
            @endif
        </div>
        <div class=col-5>
            <div class= "row flex-d justify-content-end" style = "padding-right:12px; padding-bottom:52px">
                @if ($buildMode)
                    <button class="btn btn-primary btn-top-console " onClick="viewSite('{{ $loc }}')">查看网站
                        <img src="{{ asset('icons/view.svg') }}" class="top-console-icon-view">
                    </button>
                    <form method = 'POST' action = "/page_edit/create_new/builder">
                        @csrf
                        <button type = "submit" class="btn btn-success btn-top-console">新页面
                            <img src="{{ asset('icons/new_page.svg') }}" class="top-console-icon-new">
                        </button>
                    </form>
                @else
                    @if ($editMode)
                        <button class="btn btn-success btn-top-console" id ="edit_switch_green"
                            onClick="setEditMode('off','{{ $loc }}')">编辑模式
                            <img src="{{ asset('icons/switch_on.svg') }}" class="top-console-icon-edit">

                        </button>
                    @else
                        <button class="btn btn-secondary btn-top-console" id ="edit_switch_gray"
                            onClick="setEditMode('on','{{ $loc }}')">编辑模式
                            <img src="{{ asset('icons/switch_off.svg') }}" class="top-console-icon-edit">
                        </button>
                    @endif
                @endif
                <button onClick="dashboardReturn()" class = "btn btn-secondary btn-top-console">仪表板
                    <img src = "{{ asset('/icons/meter.svg') }}" class="top-console-icon-dash">
                </button>
            </div>
        </div>

    </div>
</div>
<style>
    .btn-top-console {
        height: 50px;
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 8px;
        display: block;
        font-size: large !important;
        font-weight: 600 !important;
    }

    .top-console-icon-dash {
        height: 32px;
        margin-bottom: 4px;
        margin-left: 6px;
    }

    .top-console-icon-view {
        height: 32px;
        margin-top: 4px;
        margin-left: 6px;
    }

    .top-console-icon-new {
        height: 32px;
        margin-bottom: 4px;
        margin-left: 6px;
    }

    .top-console-icon-edit {
        height: 38px;
        margin-bottom: 4px;
        margin-left: 6px;
    }

    .edit-container {
        height: 108px;
        padding-top: 5px;
        padding-right: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
    }

    .rounded-box {
        border-radius: 8px;
        padding: 2px;
        border: 2px solid #ccc;
    }
</style>
