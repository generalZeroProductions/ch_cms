@php
    use App\Models\ContentItem;
    use Illuminate\Support\Facades\Session;
    Session::forget('returnPage');
    $contact = ContentItem::where('type', 'contact')->first();
    $thankyou = ContentItem::where('type', 'thankyou')->first();
    $cStyle = $contact->styles['title'];
    $tStyle = $thankyou->styles['title'];
    $scroll = 0;
    if (Session::has('scrollDash')) {
        $scroll = Session::get('scrollDash');
        Session::forget('scrollDash');
    }
    $inqIndex = 0;
    if (Session::has('inqIndex')) {
        $inqIndex = Session::get('inqIndex');
        Session::forget('inqIndex');
    }
    $pageIndex = 0;
    if (Session::has('pageIndex')) {
        $pageIndex = Session::get('inqIndex');
        Session::forget('pageIndex');
    }

@endphp

@extends('console.console')
@section('content')
    @php
        Session::put('buildMode', false);
    @endphp
    <br>
    @include('app.edit_mode.auth_on_off')
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
        {{-- start with pages  layout --}}
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
        <div id="pagesDiv"> </div>

        <br>
        <br>
        <div class = "row d-flex rounded-box">
            <div class="col-8 d-flex justify-content-center align-content-center" style="padding-top:8px">
                <h4>询问</h4>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-primary btn-top-console "
                    onClick=" editContactSetup('contact','{{ $cStyle }}')">
                    配置查询页面
                </button>
            </div>

            <div class="col-2"> <button class="btn btn-outline-primary btn-top-console"
                    onClick=" editContactSetup('thankyou','{{ $tStyle }}') ">
                    配置感谢页面
                </button>
            </div>

        </div>
        <div id="contact_editor" style="display:none">
            @include('console.edit_contact_body')
        </div>
        <div id="thankyou_editor" style="display:none">
            @include('console.edit_thankyou')
        </div>
        <br>
        <hr>

        {{-- start with inquires layout --}}
        <div class = "row ">
            <div class=col-md-4>
                <p class='page_list_heading'>Date </p>
            </div>
            <div class=col-md-4>
                <p class='page_list_heading'>sender </p>
            </div>
            <div class=col-md-2 style="text-align:center">
                <p class='page_list_heading'>read </p>
            </div>
            <div class=col-md-2 style="text-align:center">
                <p class='page_list_heading'>delete</p>
            </div>
        </div>

        <div id="inquiresDiv">

        </div>
    </div>
@endsection
@include('forms.main_modal')
<style>
    .btn-top-console {
        height: 50px;
        width: 150px;
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
        padding: 2px;
        border: 2px solid #ccc;
    }
</style>

<script>
    window.onload = function() {
        scriptAsset = "{{ asset('scripts/') }}/";
        iconsAsset = "{{ asset('icons/') }}/";
        paginatePages('{{ $inqIndex }}');
        paginateInquiries('{{ $inqIndex }}');
        window.scrollTo(0, 0);
    };
</script>
