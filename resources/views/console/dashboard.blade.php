@php
    use App\Models\ContentItem;
    use App\Models\User;
    use Illuminate\Support\Facades\Session;
    $allUsers = User::all();
    Session::forget('returnPage');
    $contact = ContentItem::where('type', 'contact')->first();
    $thankyou = ContentItem::where('type', 'thankyou')->first();
    $cStyle = $contact->styles['title'];
    $tStyle = $thankyou->styles['title'];
    $scroll = 0;
    if (Session::has('scrollDash')) {
        echo Session::get('scrollDash');
        $scroll = (int) Session::get('scrollDash');
        Session::forget('scrollDash');
    }
    $inqIndex = 0;
    if (Session::has('inqIndex')) {
        $inqIndex = Session::get('inqIndex');
        Session::forget('inqIndex');
    }
    $pageIndex = 0;
    if (Session::has('pageIndex')) {
        $pageIndex = Session::get('pageIndex');
        Session::forget('pageIndex');
    }
    $userIndex = 0;
    if (Session::has('userIndex')) {
        $userIndex = Session::get('userIndex');
        Session::forget('userIndex');
    }
    $warnSuper = false;
    $showUsers = false;

    $user = Auth::user();
    if (
        $user &&
        $user->id === 1 &&
        $user->password === '$2y$12$6qGz1z753cKIxg/Kn89C1.QSq0PM6jpEXlnc4yIHqWQpSAWuhE7gC'
    ) {
        $warnSuper = true;
    }
    if ($user->super) {
        $showUsers = true;
    }

@endphp

@extends('console.console')
@section('content')
    @php
        Session::put('buildMode', false);
    @endphp
    <br>

    {{-- @include('app.edit_mode.auth_on_off') --}}
    <div class="container">
        <div class = "row d-flex justify-content-between rounded-box">
            <div class="p-2">
                <button class="btn btn-primary btn-top-console " onClick="viewSite('dashboard')">查看网站
                    <img src="{{ asset('icons/view.svg') }}" class="top-console-icon">
                </button>
            </div>
            <div class="p-2 ">
                <h3 class="text-left">{{ config('app.name') }}.com 仪表板</h3>
                @if ($warnSuper)
                    <span style = "color:red"> 您已使用密码 123 以 super 身份登录。<br>为了数据的安全，您应该更改密码并添加新用户</span>
                @endif
            </div>
            <div class="p-2"> 
            <form method="GET" action="/console/logout"> @csrf
            <button type ="submit" class = "btn btn-secondary btn-top-console">登出
                    <img src = "{{ asset('/icons/logout.svg') }}" class="top-console-icon">
                </button>
                </form>
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
                <button class="btn btn-outline-primary btn-main-console"
                    onClick=" editContactSetup('contact','{{ $cStyle }}')">
                    配置查询页面
                </button>
            </div>

            <div class="col-2"> <button class="btn btn-outline-primary btn-main-console"
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
                <p class='page_list_heading'>日期 </p>
            </div>
            <div class=col-md-4>
                <p class='page_list_heading'>发件人姓名 </p>
            </div>
            <div class=col-md-2 style="text-align:center">
                <p class='page_list_heading'>阅读查询 </p>
            </div>
            <div class=col-md-2 style="text-align:center">
                <p class='page_list_heading'>删除</p>
            </div>
        </div>

        <div id="inquiresDiv">

        </div>
        <br>
        <br>

        @if ($user->id === 1)
            {{-- start with userrs layout --}}

            <div class = "row d-flex rounded-box">
                <div class="col-10 d-flex justify-content-center align-content-center" style="padding-top:8px">
                    <h4>Users</h4>
                </div>
                <div class="col-2">
                    <button class="btn btn-outline-primary btn-main-console "
                        onClick="openMainModal('addUser','{{ json_encode($allUsers) }}', 'modal-md')">
                        添加用户
                    </button>
                </div>



            </div>
            <hr>

            <div id="usersDiv">

            </div>
    </div>
    @endif
    <br>
    <br>
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

    .btn-main-console {
        height: 44px;
        width: 100%;
        margin-left: 6px;
        margin-right: 6px;
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
        paginateAll('{{ $pageIndex }}', '{{ $inqIndex }}', '{{ $userIndex }}', '{{ $showUsers }}','{{$scroll}}');
    }
      
</script>
