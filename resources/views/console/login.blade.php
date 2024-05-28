@extends('console.console')
@section('content')
    <div class="container-fluid">

        <div class="row align-items-center row-v-3" style='margin-top:20vh'>
            <div class = 'col-md-4 col-sm-0'>
            </div>
            <div class = 'col-md-4 col-sm-12 align-items-center gray-page' style='padding-bottom:10px'>
                <form method = 'POST' action='console/login'>
                    @csrf
                    <div class="form-group">
                        <label for="login">{{ config('app.name') }}.com  管理员登录</label>
                    </div>
                    <div class="form-group">
                        <label for="username">用户名</label>
                        <input type="text" class="form-control" id="name" aria-describedby="name"
                            placeholder="输入用户名" name="name">
                    </div>
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" class="form-control" id="pass_word" placeholder="密码" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary" >登录</button>
                </form>
            </div>
            <div class = 'col-md-4 col-sm-0'>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
