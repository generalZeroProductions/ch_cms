@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <div class="row align-items-center row-v-3" style='margin-top:20vh'>
            <div class = 'col-md-4 col-sm-0'>
            </div>
            <div class = 'col-md-4 col-sm-12 align-items-center gray-page' style='padding-bottom:10px'>
                <form method = 'POST' action='console/login'>
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">login</label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">username</label>
                        <input type="text" class="form-control" id="name" aria-describedby="name"
                            placeholder="Enter username" name="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="pass_word" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
