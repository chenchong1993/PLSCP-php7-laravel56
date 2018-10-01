@extends('common.layouts')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">消息管理</h4>
        </div>
    </div>

    {{--下面是选择是输入用户群组--}}
    {{--云推送接受的js代码--}}
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">

        var conn;  //定义一个链接

        /**
         * 登陆
         * @returns {boolean}
         */
        function login(conn) {
            if (!conn) {
                return false;
            }
            // var loginfo = '{"Type":101,"Appid":1,"From":23024091317405712,"To":23024091317406736,"Connid":0,"ConnServerid":0,"Gid":0,"Text":"{\\"uid\\":23024091317405712,\\"user\\":\\"u\\",\\"passwd\\":\\"bd_agent_1\\",\\"key\\":\\"\\",\\"platform\\":2,\\"lastmsgid\\":0}","Time":1463035119,"Msgid":1,"Platform":2,"Payload":null,"Options":{"TimeLive":0,"StartTime":0,"ApnsProduction":false,"Command":null}}';
            // conn.send(loginfo);

            var loginfo = '{ "Type": 101,"Appid": 10,"From": 0,"To":29914363070513161, "Connid": 0,"ConnServerid": 0, "Gid": 0,"Text": "{\\"uid\\":29914377884794889,\\"user\\":\\"u\\",\\"passwd\\":\\"bd_agent_10\\",\\"key\\":\\"\\",\\"platform\\":2,\\"lastmsgid\\":0}","Time": 1498203115,"Platform": 1,"Payload": null}';
            conn.send(loginfo);
            console.log('登陆成功');

        }
        /**
         * 获取当前时间
         * @returns {string}
         */
        function getLocalTime() {
            var date = new Date();
            var seperator1 = "-";
            var seperator2 = ":";
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
                + " " + date.getHours() + seperator2 + date.getMinutes()
                + seperator2 + date.getSeconds();
            return currentdate;
        }
        /**
         * 添加到显示框
         * @param user
         * @param time
         * @param content
         * @param position
         */
        function appendLog(user,time,content,position) {
            if (position=='left')
            {
                $('.chat').append(
                    '<li class="left clearfix">' +
                    '<span class="chat-img pull-left">' +
                    '<img class="img-circle" alt="User Avatar" src="http://placehold.it/50/55C1E7/fff">' +
                    '</span>' +
                    '<div class="chat-body clearfix">' +
                    '<div class="header">' +
                    '<strong class="primary-font">'+ user +'</strong>' +
                    '<small class="pull-right text-muted">' +
                    '<i class="fa fa-clock-o fa-fw"></i> '+ time +'' +
                    '</small>' +
                    '</div>' +
                    '<p>' +
                    content +
                    '</p>' +
                    '</div>' +
                    '</li>'
                );
            }
            if (position=='right')
            {
                $('.chat').append(
                    '<li class="right clearfix">' +
                    '<span class="chat-img pull-right">' +
                    '<img class="img-circle" alt="User Avatar" src="http://placehold.it/50/FA6F57/fff">' +
                    '</span>' +
                    '<div class="chat-body clearfix">' +
                    '<div class="header">' +
                    '<small class=" text-muted">' +
                    '<i class="fa fa-clock-o fa-fw"></i> '+ time +'</small>' +
                    '<strong class="pull-right primary-font">'+ user +'</strong>' +
                    '</div>' +
                    '<p>' +
                    content +
                    '</p>' +
                    '</div>' +
                    '</li>'
                );
            }


        }

        /**
         * 把JS接收到的云推送的数据post到后台
         * @param msg
         */
        function pushData(msg) {
            $.post("{{ url('PLSCP/saveResDate') }}", { "msg":msg },
                function(data){
                    if(data.status == 0){
                        console.log('successs');
                    }else if (data.status == 1){
                        console.log('error');
                    }
                }, "json");

        }
        /**
         * 发送消息
         * @param push_user_id
         * @param message
         * @returns {boolean}
         */
        function sendmsg(conn,push_user_id,message) {
            if (!conn) {
                return false;
            }
//            给终端发消息模板
            var msgJson = '"{\\"Type\\":1,\\"Data\\":{\\"from\\":0,\\"to\\":0,\\"content\\":\\"{\\\\\\"_id\\\\\\":3,\\\\\\"content\\\\\\":{\\\\\\"_id\\\\\\":3,\\\\\\"contentType\\\\\\":3,\\\\\\"fileName\\\\\\":null,\\\\\\"json\\\\\\":\\\\\\"'+message+'\\\\\\"},\\\\\\"contentType\\\\\\":3,\\\\\\"conversationId\\\\\\":\\\\\\"1536888885424\\\\\\",\\\\\\"conversationType\\\\\\":1,\\\\\\"createTime\\\\\\":1536888940315,\\\\\\"direct\\\\\\":2,\\\\\\"fileurl\\\\\\":null,\\\\\\"fromUserId\\\\\\":889,\\\\\\"isImportance\\\\\\":false,\\\\\\"lat\\\\\\":0.0,\\\\\\"lon\\\\\\":0.0,\\\\\\"msgId\\\\\\":0,\\\\\\"serverMessageId\\\\\\":null,\\\\\\"status\\\\\\":0,\\\\\\"targetIDs\\\\\\":\\\\\\"0\\\\\\"}\\",\\"tag\\":\\"1\\",\\"timestamp\\":1536888940}}"';
//          给云端发消息模板
//            console.log(msgJson);
//          var msgJson = message;
//            var push_user_gid = 32000004734320645;
//            console.log('00000000000000000000000000');
            var sengMsg = '{"type":2,"to":32000004734320645,"From":29914377884794889,"Gid":32000004734320645,"text":' + msgJson + ',"appid":10,"time":1508898308,"platform":1}'
            conn.send(sengMsg);
            console.log(sengMsg);
            return false

        }
        /**
         * 处理API接收消息模板
         * @param data
         */
        function API_Msg(data) {
            var text = JSON.parse(data).Text;
            var apimsg = JSON.parse(text).Data.content;
            return apimsg;
        }
        /**
         * 处理终端接收消息模板
         * @param data
         */
        function Mobile_Msg(data) {
            var text = JSON.parse(data).Text;
//            这个对象里有上传数据的很多内容
            var mobilmsg = JSON.parse(JSON.parse(text).Data.content);
            console.log(mobilmsg);
            var mobilejson = mobilmsg.content.json;
            console.log(typeof (mobilejson));
            console.log(mobilejson);
            return mobilejson;

        }

        /**
         * 推送消息
         * @param UserId
         * @param UserName
         */
        function pushMsg(UserId,UserName) {
            console.log(UserId);
            var msg = $('#btn-input');
            var conn;

            $('#btn-chat').click(function () {
                if (!conn) {
                    return false;
                }
                if (!msg.val()) {
                    return false;
                }
                var timepush = getLocalTime();
//               管理员发的消息
                console.log(msg.val());
                appendLog('admin',timepush,msg.val(),'right');
                var message =  msg.val();
                sendmsg(conn,UserId,message);
                msg.val("");
                return false
            });

            if (window["WebSocket"]) {
                conn = new WebSocket("ws://121.28.103.199:9078/ws");
                console.log("conn:", conn);
                conn.onopen = function (evt) {
                    login(conn);
                };
                conn.onclose = function (evt) {
                };

                conn.onmessage = function (evt) {
                    var timerec = getLocalTime();
                    var type = JSON.parse(evt.data).Type;
                    if (type == 102){
                        appendLog(UserName,timerec,'连接成功','left')
                        console.log(evt.data);
                    }
                    else{
//                        apimsg = API_Msg(evt.data);
//                        appendLog(UserName,timerec,apimsg,'l')
                        console.log(evt.data);
                        mobilemsg = Mobile_Msg(evt.data);
                        appendLog(UserName,timerec,mobilemsg,'left')
                    }
                }
            } else {
                appendLog($("<div><b>Your browser does not support WebSockets.</b></div>"))
            }


        }

    </script>



    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">群组列表</div>
            <table class="table table-striped table-hover table-responsive">
                <thead>
                <tr>
                    {{--<th>UID</th>--}}
                    <th>群组名</th>
                    {{--<th>注册时间</th>--}}
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        {{--<th scope="row">{{$user->uid}}</th>--}}
                        <td>{{ $group->name }}</td>
                        <td>
                            {{--<a href="{{ url('' ,['uid' => $user->uid])}}">私信</a>--}}
                            <button type="button" id="#btn-chat" class="btn btn-link" onclick="pushMsg('{{$group->gid}} ','{{ $group->name }}')">私信</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{--下面是聊天窗口布局--}}
    <div class="col-md-8">
        <div class="chat-panel panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-comments fa-fw"></i> Chat
                <div class="btn-group pull-right">
                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu slidedown">
                        <li>
                            <a href="#">
                                <i class="fa fa-refresh fa-fw"></i> Refresh
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-check-circle fa-fw"></i> Available
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-times fa-fw"></i> Busy
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-clock-o fa-fw"></i> Away
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <i class="fa fa-sign-out fa-fw"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <ul class="chat"></ul>
            </div>
            <!-- /.panel-body -->
            <div class="panel-footer">
                <div class="input-group">
                    <input class="form-control input-sm" id="btn-input" type="text" placeholder="Type your message here...">
                    <span class="input-group-btn">
                    <button class="btn btn-warning btn-sm" id="btn-chat">
                        Send
                    </button>
                </span>
                </div>
            </div>
            <!-- /.panel-footer -->
        </div>
    </div>


@stop