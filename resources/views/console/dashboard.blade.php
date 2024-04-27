@extends('console.console')
@section('content')
    @php
        use Illuminate\Support\Facades\Session;
        $editMode = false;
        if (Session::has('edit')) {
            $editMode = Session::get('edit');
        }
    @endphp
    <br>
    <div class="container">
        <div class = "row d-flex justify-content-between">
            <div class="col-md-8">
                <h3 class="text-left">{{ config('app.name') }}.com 仪表板</h3>
            </div>
            <div class="col-md-2 ">
            </div>
            <div class="col-md-2 " style = "padding-right:0vw; margin-right:0px">
                <button class = "btn btn-secondary btn-top-dash">登出<img src = "{{ asset('/icons/logout.svg') }}"
                        style="height: 22px; margin-left: 10px;margin-bottom: 3px"></button>
            </div>
        </div>
        <br>
        <div class="row justify-content-between">
            <form method = 'POST' action = "/page_edit/create_new">
                @csrf
                <button type = "submit" class="btn btn-secondary btn-dash col-sm">新页面
                    <img src="{{ asset('icons/new_page.svg') }}"
                        style="height: 30px; margin-left: 15px; margin-bottom: 5px">
                </button>
            </form>
            @if ($editMode)
                <button class="btn btn-success btn-dash col-sm" id ="edit_switch_green" onClick="setEditMode('off')">编辑模式
                    <img src="{{ asset('icons/switch_on.svg') }}"
                        style="height: 44px; margin-left: 20px;margin-bottom: 5px">
                </button>
            @else
                <button class="btn btn-secondary btn-dash col-sm" id ="edit_switch_gray" onClick="setEditMode('on')">编辑模式
                    <img src="{{ asset('icons/switch_off.svg') }}"
                        style="height: 44px; margin-left: 20px;margin-bottom: 5px">
                </button>
            @endif
            <button class="btn btn-secondary btn-dash col-sm" onClick="viewSite()">查看网站
                <img src="{{ asset('icons/view.svg') }}" style="height: 30px; margin-left: 5px;  margin-bottom: 5px">
            </button>
        </div>
        <br>
        <h5> 当前使用的所有页面 </h5>
        <hr>
        <div class = "row ">
            <div class=col-md-4>
                <p class='page_list_heading'>页面标题 </p>
            </div>
            <div class=col-md-4>
                <p class='page_list_heading'>第一行的描述 </p>
            </div>
            <div class=col-md-2 style="text-align:center">
                <p class='page_list_heading'>编辑页面 </p>
            </div>
            <div class=col-md-2 style="text-align:center">
                <p class='page_list_heading'>删除页面</p>
            </div>
        </div>
        <div id="pagesDiv">
        </div>
    </div>

    @if (Auth::check())
        <h2 style = "color:red"> AUTH </h2>
    @endif
@endsection

<style>
    .page_list_heading {
        font-size: large !important;
        font-weight: 400 !important;
    }

    .btn-dash {
        display: block;
        font-size: x-large !important;
        font-weight: 700 !important;
        height: 60px;
        padding: 10px 20px;
        margin-left: 20px;
        margin-right: 20px;
        text-align: center;
        text-decoration: none;
        color: #333;
        background-color: #ddd;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-top-dash {
        display: block;
        font-size: large !important;
        font-weight: 600 !important;
        height: 40px;
    }
</style>

<script>
    window.onload = function() {
        scriptAsset = "{{ asset('scripts/') }}/";
        paginatePages();
    };
</script>