<!DOCTYPE html>
<html style="height: 100%">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>大众位置服务云平台</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('static/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('static/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('static/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('static/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    {{--HUI的图标库--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Hui-iconfont/1.0.8/iconfont.css') }}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/dijit/themes/tundra/tundra.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/esri/css/esri.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/Ips/css/widget.css') }}" />
    <script type="text/javascript" src="{{ asset('static/Ips_api_javascript/init.js') }}"></script>


    <style type="text/css">
        /*.user-msg{position:absolute;left:810px;top:10px;z-index:auto;width:500px;background-color:#f6f6f6}*/
        .map1-col{position:absolute;left:10px;top:10px;z-index:0;width:1200px;background-color:#f6f6f6}
        .map2-col{position:absolute;left:10px;top:350px;z-index:1;width:1200px;background-color:#f6f6f6}
        .map3-col{position:absolute;left:10px;top:740px;z-index:3;width:600px;background-color:#f6f6f6}
    </style>
</head>
<body style="height: 100%; margin: 0">

<script>
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
        var map1 = new Map("map1", {
            logo:false,
            center: [114.3489254,38.24769],
        });
        var map2 = new Map("map2", {
            logo:false,
            center: [114.3489254,38.24769],
        });
        var map3 = new Map("map3", {
            logo:false,
            center: [114.3486414,38.24770],
        });
        //初始化F1楼层平面图
        var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
        var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
        var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
        map1.addLayer(f1);
        map2.addLayer(f2);
        map3.addLayer(f3);

    });


</script>

<div class="row">
    <div class="map1-col">
        <div id="map1"></div>
    </div>
    <div class="map2-col">
        <div id="map2"></div>
    </div>
    <div class="map3-col">
        <div id="map3"></div>
    </div>
</div>
</body>
</html>