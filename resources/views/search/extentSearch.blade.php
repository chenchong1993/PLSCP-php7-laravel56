@extends('common.layouts')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">普通查询</h4>
        </div>
    </div>
    @include('common.validator')
    @include('common.message')

    <div class="panel panel-default">
        <div class="panel-heading">扩展查询</div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">查询内容</label>
                    <div class="col-sm-5">
                        <input type="text" name="content"class="form-control" id="content" placeholder="请输入查询内容">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">查询类别</label>

                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="type"id="type" value="10"> 人名
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type"id="type" value="20"> 地名
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type"id="type" value="30"> 物名
                        </label>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">查询</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop