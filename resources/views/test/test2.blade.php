<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat Example</title>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">

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
        $(function() {

            var conn;
            var msg = $("#msg");
            var log = $("#log");

            function appendLog(msg) {

                console.log(msg);
                var d = log[0]
                var doScroll = d.scrollTop == d.scrollHeight - d.clientHeight;
                msg.appendTo(log)
                if (doScroll) {
                    d.scrollTop = d.scrollHeight - d.clientHeight;
                }
            }

            function login(){
                if (!conn) {
                    return false;
                }
                // var loginfo = '{"Type":101,"Appid":1,"From":23024091317405712,"To":23024091317406736,"Connid":0,"ConnServerid":0,"Gid":0,"Text":"{\\"uid\\":23024091317405712,\\"user\\":\\"u\\",\\"passwd\\":\\"bd_agent_1\\",\\"key\\":\\"\\",\\"platform\\":2,\\"lastmsgid\\":0}","Time":1463035119,"Msgid":1,"Platform":2,"Payload":null,"Options":{"TimeLive":0,"StartTime":0,"ApnsProduction":false,"Command":null}}';
                // conn.send(loginfo);

                var loginfo = '{ "Type": 101,"Appid": 10,"From": 0,"To":29914363070513161, "Connid": 0,"ConnServerid": 0, "Gid": 0,"Text": "{\\"uid\\":29914377884794889,\\"user\\":\\"u\\",\\"passwd\\":\\"bd_agent_10\\",\\"key\\":\\"\\",\\"platform\\":2,\\"lastmsgid\\":0}","Time": 1498203115,"Platform": 1,"Payload": null}';
                conn.send(loginfo);
            }

            $("#form").submit(function() {
                if (!conn) {
                    return false;
                }
                if (!msg.val()) {
                    return false;
                }
                var sengMsg = '{"type":1,"content":"{\"content\":{\"contentType\":3,\"json\":\":\"http://10.1.2.32:8080/1,01a4df39f6c8\"},\"},\"contentType\":3,\"createTime\":1527748134869,\"direct\":2,\"fileurl\":\"\",\"fromUserId\":50972738601504,\"lat\":0.0,\"lon\":0.0,\"msgId\":0,\"serverMessageId\":null,\"status\":0,\"targetIDs\":\"63464736424480\",\"isImportance\":true}","to":31757653088665605,"time":1464749355,"from":62083726721568}'
//                var sengMsg = '{"type":1,"to":29914363070513161,"text":"'+msg.val()+'","appid":10,"time":1508898308,"platform":1}'
                conn.send(sengMsg);
                msg.val("");
                return false
            });

            if (window["WebSocket"]) {
                conn = new WebSocket("ws://121.28.103.199:9078/ws");
                console.log("conn:",conn)

                conn.onopen = function(evt) {
                    login()
                };
                conn.onclose = function(evt) {
                    appendLog($("<div><b>Connection closed.</b></div>"))
                }
                conn.onmessage = function(evt) {
                    pushData(evt.data);
                    appendLog($("<div/>").text(evt.data))
                }
            } else {
                appendLog($("<div><b>Your browser does not support WebSockets.</b></div>"))
            }
        });
    </script>
    <style type="text/css">
        html {
            overflow: hidden;
        }

        body {
            overflow: hidden;
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            background: gray;
        }

        #log {
            background: white;
            margin: 0;
            padding: 0.5em 0.5em 0.5em 0.5em;
            position: absolute;
            top: 0.5em;
            left: 0.5em;
            right: 0.5em;
            bottom: 3em;
            overflow: auto;
        }

        #form {
            padding: 0 0.5em 0 0.5em;
            margin: 0;
            position: absolute;
            bottom: 1em;
            left: 0px;
            width: 100%;
            overflow: hidden;
        }

    </style>
</head>
<body>
<div id="log"></div>
<form id="form">
    <input type="submit" value="Send" />
    <input type="text" id="msg" size="64"/>
</form>
</body>
</html>
