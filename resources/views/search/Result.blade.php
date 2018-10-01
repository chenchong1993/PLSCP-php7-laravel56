@extends('common.layouts')
{{--继承模板布局--}}
@section('content')
    {{--那个区块--}}
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">普通查询</h4>
        </div>
    </div>
    @include('common.message')
    <!-- 自定义内容区域 -->
    <div class="panel panel-default">
        <div class="panel-heading">查询结果</div>
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>UID</th>
                <th>用户名</th>
                <th>appid</th>
                <th>性别</th>
                <th>邮箱</th>
                {{--<th>注册时间</th>--}}
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->uid}}</th>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->appid }}</td>
                    <td>{{ $user->sex }}</td>
                    <td>{{ $user->email}}</td>
                    {{--<td>{{ date('Y-m-d', $user->registertime) }}</td>--}}
                    <td>
                        <a href="{{ url('userDetail' ,['uid' => $user->uid])}}">详情</a>
                        <a href="{{ url('userUpdate', ['uid' => $user->uid]) }}">修改</a>
                        <a href="{{ url('/api/apiUserDelete', ['uid' => $user->uid]) }}"
                           onclick="if (confirm('确定要删除吗？') == false) return false;">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop