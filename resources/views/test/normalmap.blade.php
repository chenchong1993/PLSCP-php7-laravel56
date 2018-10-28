@extends('common.layouts')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">基础地图</h4>
        </div>
    </div>
       <style>
        html, body, #map {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        #render1{
            position: absolute;top:30px;left:200px;font-size: 18px;
        }
        #render2{
            position: absolute;top:30px;left:240px;font-size: 18px;
        }
        #render3{
            position: absolute;top:30px;left:280px;font-size: 18px;
        }
    </style>

    <script>
        function catUserTrail(uid) {

            console.log("2:",uid+" ");
            var startTime = $('#startTime').val();
            var endTime = $('#endTime').val();
            window.location.href = '/userTrail?uid=' + uid + '&startTime=' + startTime +'&endTime=' + endTime;
        }

        var HTHT_SERVER_IP = "121.28.103.199:9078"; //航天宏图服务器地址
        var HTHT_TYPE_LOGIN_SCUUESS = 102; //航天宏图消息类型:登录成功
        var HTHT_TYPE_RECEIVE_MSG = 1; //航天宏图消息类型:收到消息
        var INTERVAL_TIME = 2; //数据刷新间隔时间
        require([
            "Ips/map",
            "Ips/widget/IpsMeasure",
            "Ips/layers/DynamicMapServiceLayer",
            "Ips/layers/FeatureLayer",
            "Ips/layers/GraphicsLayer",
            "esri/graphic",
            "esri/geometry/Point",
            "esri/geometry/Polyline",
            "esri/geometry/Polygon",
            "esri/InfoTemplate",
            "esri/symbols/SimpleMarkerSymbol",
            "esri/symbols/SimpleLineSymbol",
            "esri/symbols/SimpleFillSymbol",
            "esri/symbols/PictureMarkerSymbol",
            "esri/symbols/TextSymbol",
            "dojo/colors",
            "dojo/on",
            "dojo/dom",
            "dojo/domReady!"
        ], function (Map, IpsMeasure,DynamicMapServiceLayer,FeatureLayer, GraphicsLayer, Graphic, Point, Polyline, Polygon, InfoTemplate, SimpleMarkerSymbol, SimpleLineSymbol,
                     SimpleFillSymbol, PictureMarkerSymbol, TextSymbol, Color, on, dom) {
            var map = new Map("map", {
                logo:false,
                center: [114.3489254,38.2477279]
            });
            var measure = new IpsMeasure({
                map:map
            });
            var pointLayerF1 = new GraphicsLayer();
            var pointLayerF2 = new GraphicsLayer();
            var pointLayerF3= new GraphicsLayer();
            //初始化F1楼层平面图
            var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
            var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
            var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
            map.addLayer(f1);
            map.addLayer(f2);
            map.addLayer(f3);
            f2.hide();
            f3.hide();
            pointLayerF2.hide();
            pointLayerF3.hide();
            measure.startup();
            /**
             *添加用户坐标
             * */
            function addUserPoint(id,uid, lng, lat, name, phone,floor,status) {

                //定义点的几何体
                //38.2477770 114.3489115
                var picpoint = new Point(lng,lat);
                // //定义点的图片符号
                var picSymbol;
                if (status == 'normal')
                    picSymbol = new PictureMarkerSymbol("{{ asset('static/Ips_api_javascript/Ips/image/marker.png') }}",24,24);
                else if (status == 'danger')
                    picSymbol = new PictureMarkerSymbol("{{ asset('static/Ips_api_javascript/Ips/image/marker.png') }}",24,24);

                //定义点的图片符号
                var attr = {"name": name, "phone": phone};
                //信息模板
                var infoTemplate = new InfoTemplate();
                infoTemplate.setTitle('用户');
                infoTemplate.setContent(
                    "<b>名称:</b><span>${name}</span><br>"
                    + "<b>手机号:</b><span>${phone}</span><br>"
                    + "<b>起始时间：</b><input type='text' name='startTime'class='' id='startTime' placeholder='2018-10-22 11:36:07'><br>"
                    + "<b>终止时间：</b><input type='text' name='endTime'class='' id='endTime' placeholder='2018-10-22 11:36:07'><br>"
                    + "<button class='' onclick=catUserTrail(" + "'" + uid + "'" + ") > 查看该用户轨迹</button>"
                );
                var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
                if (floor == 1){
                    pointLayerF1.add(picgr);
                    map.addLayer(pointLayerF1);
                }
                if (floor == 2){
                    pointLayerF2.add(picgr);
                    map.addLayer(pointLayerF2);
                }
                if (floor == 3){
                    pointLayerF3.add(picgr);
                    map.addLayer(pointLayerF3);
                }
            }
        /**
         * 从数据库读取用户列表和用户最新坐标并更新界面
         */
        function getDataAndRefresh() {
            // 从云端读取数据
            $.get("/api/apiGetAllUserNewLocationList",
                {},
                function (dat, status) {
                    if (dat.status == 0) {
                        // 删除数据
                        pointLayerF1.clear();
                        pointLayerF2.clear();
                        pointLayerF3.clear();
                        // 添加人
                        //注销掉因为先单用户测试
                        // for (var i in dat.data) {
                        for (var i=0; i<10; i++) {
                            // console.log(dat.data[i].username);
                            console.log(dat.data[i].location.floor);
                            addUserPoint(
                                dat.data[i].id,
                                dat.data[i].uid,
                                dat.data[i].location.lng,
                                dat.data[i].location.lat,
                                dat.data[i].username,
                                dat.data[i].tel_number,
                                dat.data[i].location.floor,
                                'normal'
                            );
/**
                            if (dat.data[i].location.floor == 1) {
                                lineArrayF1.push([dat.data[i].location.lng,dat.data[i].location.lat]);
                                var line= new Polyline(lineArrayF1);
                                //定义线的符号
                                var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
                                var linegr=new Graphic(line,lineSymbol);
                                lineLayerF1.add(linegr);
                                map.addLayer(lineLayerF1);

                            }
                            if (dat.data[i].location.floor == 2) {

                                lineArrayF2.push([dat.data[i].location.lng,dat.data[i].location.lat]);
                                var line= new Polyline(lineArrayF2);
                                //定义线的符号
                                var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
                                var linegr=new Graphic(line,lineSymbol);
                                lineLayerF2.add(linegr);
                                map.addLayer(lineLayerF2);

                            }
                            if (dat.data[i].location.floor == 3) {

                                lineArrayF3.push([dat.data[i].location.lng,dat.data[i].location.lat]);
                                var line= new Polyline(lineArrayF3);
                                //定义线的符号
                                var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
                                var linegr=new Graphic(line,lineSymbol);
                                lineLayerF3.add(linegr);
                                map.addLayer(lineLayerF3);

                            }
**/
                        }
                    } else {
                        console.log('ajax error!');
                    }
                }
            );
        }
            on(dom.byId("render1"),"click",function () {
                f1.show();
                f2.hide();
                f3.hide();
                pointLayerF1.show();
                pointLayerF2.hide();
                pointLayerF3.hide();
            });
            on(dom.byId("render2"),"click",function () {

                f1.hide();
                f3.hide();
                f2.show();
                pointLayerF1.hide();
                pointLayerF3.hide();
                pointLayerF2.show();
            });
            on(dom.byId("render3"),"click",function () {

                f1.hide();
                f2.hide();
                f3.show();
                pointLayerF1.hide();
                pointLayerF2.hide();
                pointLayerF3.show();
            });
        //循环执行
        setInterval(getDataAndRefresh, (INTERVAL_TIME * 1000))
        });
    </script>
    <div class="row">
        <div class="map-col">
            <div id="map"></div>
            <button id="render1">F1</button>
            <button id="render2">F2</button>
            <button id="render3">F3</button>
        </div>
    </div>
@stop