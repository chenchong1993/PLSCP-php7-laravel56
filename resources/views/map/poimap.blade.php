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
    </style>

    <script>
        require([
            "Ips/map",
            "Ips/widget/IpsMeasure",
            "Ips/layers/DynamicMapServiceLayer",
            "Ips/layers/GraphicsLayer",
            "esri/graphic",
            "esri/geometry/Point",
            "esri/InfoTemplate",
            "esri/symbols/PictureMarkerSymbol",
            "dojo/domReady!"
        ], function (Map,IpsMeasure,DynamicMapServiceLayer,GraphicsLayer,Graphic,Point,InfoTemplate,
                     PictureMarkerSymbol){
                var map = new Map("map", {
                    logo:false,
                    center: [114.3489254,38.2477279]
                });
                var measure = new IpsMeasure({
                    map:map
                });


            //初始化F1楼层平面图
            var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
            map.addLayer(f1);

            var layer = new GraphicsLayer();
            //定义点的图片符号
            var picSymbol = new PictureMarkerSymbol("{{ asset('static/Ips_api_javascript/Ips/image/marker.png') }}",24,24);
            //定义点的图片符号
            var attr = {"name":"1号标注点","time":"2018-08-01"};
            //信息模板
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle("标注点");
            infoTemplate.setContent("<b>名称:</b><span>${name}</span><br>"
                +"<b>时间:</b><span>${time}</span><br>");
            var point=new Array();
            var picgr = new Array();
            var lat = new Array();
            var lon = new Array();
            @foreach($pois as $poi)
                lat.push("{{$poi->lat}}");
                lon.push("{{$poi->long}}");
            @endforeach
            console.log(lat);
            console.log(lon);
            for (i=0;i<lat.length;i++){
                point[i] = new Point(lon[i],lat[i]);
                picgr[i] = new Graphic(point[i],picSymbol,attr,infoTemplate);
                layer.add(picgr[i]);
            }
            map.addLayer(layer);
            measure.startup();

        });
    </script>
    <div class="row">
        <div class="map-col">
            <div id="map"></div>
        </div>
    </div>
@stop