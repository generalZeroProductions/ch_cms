@php
    $loc = Session::get('location');
    $returnLoc;
    $editMode = getEditMode();
    if (Session::has('returnPage')) {
        if (Session::get('returnPage') !== '') {
            $returnLoc = Session::get('returnPage');
        } else {
            $returnLoc = $loc;
        }
    }

@endphp

<div class ='edit-container'>
    <div class="row d-flex justify-content-end rounded-box">
        <div class=col-2>
            @include('app.auth_on_off')
        </div>
        <div class=col-5>
            <div class="row ">
                return = {{ Session::get('returnPage') }}

                &nbsp;&nbsp;&nbsp; /tab = {{ Session::get('tabId') }}

                &nbsp;&nbsp;&nbsp; / build = {{ Session::get('buildMode') }}



            </div>

            <div class=row>

                &nbsp;&nbsp;&nbsp; /edit = {{ Session::get('editMode') }}

                &nbsp;&nbsp;&nbsp; /location = {{ Session::get('location') }}

            </div>
        </div>
        <div class=col-5>
            <div class= "row flex-d justify-content-end" style = "padding-right:12px">

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
                margin-bottom: 4px;
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
                height: 80px;
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
