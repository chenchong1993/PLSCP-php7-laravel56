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
        <div class="panel-heading">修改用户</div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-5">
                        <input type="text" name="username"
                               value="{{old('username')?old('username'):$users->username}}"
                               class="form-control" id="usename" placeholder="请输入用户名">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">性别</label>

                    <div class="col-sm-5">
                        <input type="text" name="sex"
                               value="{{old('sex')?old('sex'):$users->sex}}"
                               class="form-control" id="sex" placeholder="请输入性别">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">密码</label>

                    <div class="col-sm-5">
                        <input type="text" name="password"
                               value="{{old('password')?old('password'):$users->password}}"
                               class="form-control" id="password" placeholder="请输入密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">email</label>

                    <div class="col-sm-5">
                        <input type="text" name="email"
                               value="{{old('email')?old('email'):$users->email}}"
                               class="form-control" id="email" placeholder="请输入email">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">group_id</label>

                    <div class="col-sm-5">
                        <input type="text" name="group_id"
                               value="{{old('group_id')?old('group_id'):$users->group_id}}"
                               class="form-control" id="group_id" placeholder="请输入email">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">手机号码</label>

                    <div class="col-sm-5">
                        <input type="text" name="mobile"
                               value="{{old('tel_number')?old('tel_number'):$users->tel_number}}"
                               class="form-control" id="mobile" placeholder="请输入手机号码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">地址</label>

                    <div class="col-sm-5">
                        <input type="text" name="address"
                               value="{{old('address')?old('address'):$users->address}}"
                               class="form-control" id="address" placeholder="请输入地址">
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