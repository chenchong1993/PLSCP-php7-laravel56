@extends('common.layouts')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">用户管理</h4>
        </div>
    </div>
    @include('common.validator')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">新增用户</div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="{{url('/api/apiUserAdd')}}">
                {{--{{ csrf_field() }}--}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-5">
                        <input type="text" name="username"class="form-control" id="name" placeholder="请输入用户名">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密码</label>

                    <div class="col-sm-5">
                        <input type="password" name="password"class="form-control" id="password" placeholder="请输入密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">手机号</label>

                    <div class="col-sm-5">
                        <input type="text" name="mobile"class="form-control" id="mobile" placeholder="请输入手机号">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">email</label>

                    <div class="col-sm-5">
                        <input type="text" name="email"class="form-control" id="email" placeholder="请输入email">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>

                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="sex"id="sex" value="20"> 男
                        </label>
                        {{--@foreach($users->sex() as $ind=>$val)--}}
                        {{--<label class="radio-inline">--}}
                        {{--<input type="radio" name="sex"name="sex"--}}
                        {{--value="{{$ind}}"> {{$val}}--}}
                        {{--</label>--}}
                        {{--@endforeach--}}
                        <label class="radio-inline">
                            <input type="radio" name="sex"id="sex" value="30"> 女
                        </label>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
