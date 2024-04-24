@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <div class="row align-items-center row-v-3" style='margin-top:20vh'>
            <div class = 'col-md-4 col-sm-0'>
            </div>
            <div class = 'col-md-4 col-sm-12 align-items-center gray-page' style='padding-bottom:10px'>
                <form>
                 <div class="form-group">
                        <label for="exampleInputEmail1">login</label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">username</label>
                        <input type="text" class="form-control" id="user_name" aria-describedby="emailHelp"
                            placeholder="Enter username" name="user_name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="pass_word" placeholder="Password" name="pass_word">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class = 'col-md-4 col-sm-0'>
            </div>
        </div>
    </div>
@endsection
