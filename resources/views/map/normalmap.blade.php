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
                logo:false
            });
            var measure = new IpsMeasure({
                map:map
            });




            //初始化F1楼层平面图
            var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
            var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
            var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
            map.addLayer(f1);
            map.addLayer(f2);
            map.addLayer(f3);
            f2.hide();
            f3.hide();
            //初始化GraphicsLayer
            var pointLayer = new GraphicsLayer();
            map.addLayer(pointLayer);
            measure.startup();

            var linelayer = new GraphicsLayer();
            /**
            var layer = new GraphicsLayer();
            var line= new Polyline([[114.348556,38.247946],[114.348769,38.247855]]);
            //定义线的符号
            var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
            var linegr=new Graphic(line,lineSymbol);
            layer.add(linegr);
            map.addLayer(layer);
             **/






            function addUserPoint(id, lng, lat, name, phone, status) {

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
                    + "<b>手机号:</b><span>${phone}</span><br><br>"
                );
                var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
                pointLayer.add(picgr);
            }

        /**
         * 从数据库读取用户列表和用户最新坐标并更新界面
         */

        var lineArray=[];
        function getDataAndRefresh() {

            // 从云端读取数据
            $.get("/api/apiGetAllUserNewLocationList",
                {},
                function (dat, status) {

                    if (dat.status == 0) {

                        // var lineArray=new Array();
                        // 删除数据
                        pointLayer.clear();
                        // 添加人
                        //注销掉因为先单用户测试
                        // for (var i in dat.data) {
                        for (var i=0; i<1; i++) {
                            // console.log(dat.data[i].username);
                            // console.log(dat.data[i].location.lat);
                            addUserPoint(
                                dat.data[i].id,
                                dat.data[i].location.lng,
                                dat.data[i].location.lat,
                                dat.data[i].username,
                                dat.data[i].tel_number,
                                'normal'
                            );

                            lineArray.push([dat.data[i].location.lng,dat.data[i].location.lat]);
                            var line= new Polyline(lineArray);
                            //定义线的符号
                            var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
                            var linegr=new Graphic(line,lineSymbol);
                            linelayer.add(linegr);
                            map.addLayer(linelayer);

                            if (dat.data[i].location.floor == 1) {
                                f1.show();
                                f2.hide();
                                f3.hide();

                            }
                            if (dat.data[i].location.floor == 2) {

                                f1.hide();
                                f3.hide();
                                f2.show();

                            }
                            if (dat.data[i].location.floor == 3) {

                                f1.hide();
                                f2.hide();
                                f3.show()

                            }
                        }

                    } else {
                        console.log('ajax error!');
                    }
                }
            );
        }

        //循环执行
        setInterval(getDataAndRefresh, (INTERVAL_TIME * 1000))

        });


    </script>
    <div class="row">
        <div class="map-col">
            <div id="map"></div>
        </div>
    </div>
@stop