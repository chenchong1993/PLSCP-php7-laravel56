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
    <script type="text/javascript" src="{{ asset('static/Ips_api_javascript/init.js') }}"></script>
    <script>
        require([
            "Ips/map",
            "Ips/widget/IpsMeasure",
            "Ips/layers/DynamicMapServiceLayer",
            "Ips/layers/FeatureLayer",
            "Ips/renderers/HeatmapRenderer",
            "dojo/on",
            "dojo/dom",
            "dojo/domReady!"
        ], function (Map,IpsMeasure,DynamicMapServiceLayer,FeatureLayer,HeatmapRenderer,on,dom){
            var map = new Map("map", {
                logo:false,
                center: [114.3489254,38.2477279]
            });
            var measure = new IpsMeasure({
                map:map
            });
            //初始化F1楼层平面图
            var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
            var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
            var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
            var network1 = new FeatureLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floornetworkone/MapServer/0");
            var network2 = new FeatureLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floornetworktwo/MapServer/0");
            var network3 = new FeatureLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floornetworkthree/MapServer/0");
            map.addLayer(f1);
            map.addLayer(f2);
            map.addLayer(f3);
            map.addLayer(network1);
            map.addLayer(network2);
            map.addLayer(network3);
            f2.hide();
            f3.hide();
            network2.hide();
            network3.hide();
            measure.startup();

            on(dom.byId("render1"),"click",function () {

                f1.show();
                f2.hide();
                f3.hide();
                network1.show();
                network2.hide();
                network3.hide()

            })
            on(dom.byId("render2"),"click",function () {

                f1.hide();
                f3.hide();
                f2.show();
                network1.hide();
                network3.hide();
                network2.show();

            })
            on(dom.byId("render3"),"click",function () {

                f1.hide();
                f2.hide();
                f3.show()
                network1.hide();
                network2.hide();
                network3.show();

            })
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