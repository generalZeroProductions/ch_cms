@php
Session::put('returnPage','');
@endphp

@extends('console.console')
@section('content')
    @php
        use Illuminate\Support\Facades\Session;
        Session::put('buildMode', false);
    @endphp
    <br>
    @include('app//auth_on_off')
    <div class="container">
        <div class = "row d-flex justify-content-between rounded-box">
            <div class="p-2">
                <button class="btn btn-primary btn-top-console " onClick="viewSite('dashboard')">查看网站
                    <img src="{{ asset('icons/view.svg') }}" class="top-console-icon">
                </button>
            </div>
            <div class="p-2 ">
                <h3 class="text-left">{{ config('app.name') }}.com 仪表板</h3>
            </div>
            <div class="p-2"> <button class = "btn btn-secondary btn-top-console">登出
                    <img src = "{{ asset('/icons/logout.svg') }}" class="top-console-icon">
                </button>
            </div>

        </div>
        <br>
        <div class="row justify-content-between">
            <div class="p-2">
                <h5> 当前使用的所有页面 </h5>
            </div>
            <div class="p-2">
            </div>
            <div class="p-2">
                <form method = 'POST' action = "/page_edit/create_new/dashboard">
                    @csrf
                    <button type = "submit" class="btn btn-success btn-top-console">新页面
                        <img src="{{ asset('icons/new_page.svg') }}" class="top-console-icon">
                    </button>
                </form>
            </div>
        </div>
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

@endsection
@include('forms.main_modal')
<style>
    .btn-top-console {
        height: 50px;
        width:150px;
        margin-left: 10px;
        margin-right: 10px;
        display: block;
        font-size: large !important;
        font-weight: 600 !important;
    }

    .page_list_heading {
        font-size: large !important;
        font-weight: 400 !important;
    }

    .top-console-icon {
        height: 22px;
        margin-bottom: 4px
    }

    .rounded-box {
        border-radius: 8px;
        /* Adjust the value to control the roundness of the corners */
        padding: 2px;
        /* Adjust the value to control the padding */
        border: 2px solid #ccc;
        /* Optional: add a border for better visibility */
    }
</style>

<script>
    window.onload = function() {
        scriptAsset = "{{ asset('scripts/') }}/";
        paginatePages();
    };
</script>
