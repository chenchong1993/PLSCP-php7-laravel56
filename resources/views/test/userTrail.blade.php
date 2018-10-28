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
        function returnNormalMap() {
            window.location.href = '/normalMap';
        }
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
            pointLayerF1.show();
            pointLayerF2.hide();
            pointLayerF3.hide();
            measure.startup();

            /**
             *添加用户坐标
             * */
            function addUserPoint(id,uid, lng, lat,floor,status) {

                var name = '当前用户';
                var phone = 121;
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
                    // + "<b>手机号:</b><span>${phone}</span><br>"
                    + "<button class='' onclick='returnNormalMap()' >返回查看用户分布图</button>"
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
            @foreach($userPositionLists as $userPositionList)
                console.log({{$userPositionList->lng}});
                addUserPoint(
                    {{$userPositionList->id}},
                    {{$userPositionList->uid}},
                    {{$userPositionList->lng}},
                    {{$userPositionList->lat}},
                    {{$userPositionList->floor}},
                    'normal'
                );
            @endforeach
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