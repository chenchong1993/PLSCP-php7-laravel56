@extends('common.layouts')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">消息管理</h4>
        </div>
    </div>

    {{--下面是选择是输入用户群组--}}
    <script language="javascript">
        function print(){
            var a=myform.name.value;
            alert(a);
        }
    </script>
    <div class="panel panel-default">
        <div class="panel-heading">消息发送</div>
        <div class="panel-body">
            <form class="form-horizontal"  name="myform">
                <div class="form-group">
                    <label for="names" class="col-sm-2 control-label">发送用户ID</label>
                    <div class="col-sm-5">
                        <input type="text" name="name"class="form-control" id="name" placeholder="请输入推送消息的用户">
                    </div>
                    <div class="col-sm-5">
                        <button type="button" name="button" value="ok" onclick="print()"  class="btn btn-primary">确认</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop