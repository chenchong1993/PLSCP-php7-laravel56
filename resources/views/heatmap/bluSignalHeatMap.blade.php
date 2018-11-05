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
    <script src="{{ asset('Ips_api_javascript/echarts.js') }}"></script>
    <script src="{{ asset('Ips_api_javascript/echartsExtent.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/dijit/themes/tundra/tundra.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/esri/css/esri.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/Ips/css/widget.css') }}" />
    <script type="text/javascript" src="{{ asset('static/Ips_api_javascript/init.js') }}"></script>
    <script src="{{ asset('static/vendor/jquery/jquery.min.js') }}"></script>
    {{--修改三张地图尺寸--}}
    <style type="text/css">
        /*.user-msg{position:absolute;left:810px;top:10px;z-index:auto;width:500px;background-color:#f6f6f6}*/
        .map1-col{position:absolute;left:10px;top:10px;z-index:0;width:1200px;background-color:#f6f6f6}
        .map2-col{position:absolute;left:10px;top:350px;z-index:1;width:1200px;background-color:#f6f6f6}
        .map3-col{position:absolute;left:10px;top:740px;z-index:3;width:600px;background-color:#f6f6f6}
    </style>
</head>
<body>
{{--/*定义放大缩小按钮风格*/--}}
<style>
    .menu-btn {
        position: fixed;top:30px;left:1140px;font-size: 18px;
    }
    #showWifi{
        top:30px;
    }
    #showBluetooth{
        top:70px;
    }
    #showRSS{
        top:110px;
    }
    #showIndex{
        top:150px;
    }
</style>
<style>
    html, body, #map1,map2,map3{
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="row">
    <div class="map1-col">
        <div id="map1"></div>
    </div>
    <div class="map2-col">
        <div id="map2"></div>
        <h2 class="menu-btn" style="left: 43%;font-size: 35px;color: #0c0c0c;top: 10px">RSS</h2>
        <button class="menu-btn" id="showWifi" onclick=showWifi()>WIFI</button>
        <button class="menu-btn" id="showBluetooth" onclick=showBluetooth()>蓝牙</button>
        <button class="menu-btn" id="showRSS" onclick=showRSS()>伪卫星</button>
        <button class="menu-btn" id="showIndex" onclick=showIndex()>返回首页</button>

    </div>
    <div class="map3-col">
        <div id="map3"></div>
    </div>
</div>
<script>
    var dojoConfig={
        async: true,
        packages: [{
            name: "src",
            location: location.pathname.replace(/\/[^/]+$/, "")+"/src"
        }]
    }
</script>
<script>
    function showWifi() {
        window.location.href = '/wifiSignalHeatMap';
    }
    function showBluetooth() {
        window.location.href = '/bluSignalHeatMap';
    }
    function showRSS() {
        window.location.href = '/rssHeatMap';
    }
    function showIndex() {
        window.location.href = '/index';
    }
    /**
     * 地图需求文件
     */
    require([
        "Ips/map",
        "src/Echarts3Layer",
        "Ips/layers/DynamicMapServiceLayer",
        "dojo/on",
        "dojo/dom",
        "dojo/domReady!"
    ], function (Map,Echarts3Layer,DynamicMapServiceLayer,on,dom){
        /**
         * 定义三张地图，并设定必要参数
         */
        var map1 = new Map("map1", {
            logo:false,
            center: [114.3489254,38.24772],
        });
        var map2 = new Map("map2", {
            logo:false,
            center: [114.3489254,38.24777],
        });
        var map3 = new Map("map3", {
            logo:false,
            center: [114.3486414,38.247770],
        });
        /**
         * 初始化楼层平面图
         */
        var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
        var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
        var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
        map1.addLayer(f1);
        map2.addLayer(f2);
        map3.addLayer(f3);

        /**
         * 从数据库获取热力图数据
         */
        function getHeatMap(type,floor,point,map){
            /**
             * 调用获取热力图数据api接口
             */
            $.post("/api/heatMapData",
                {
                    type:type,
                    floor:floor
                },
                function (data) {
                    /**
                     * jQuery.parseJSON(data) 把json字符串转成json对象
                     */
                    var jsonObj = jQuery.parseJSON(data);
                    /**
                     * 循环生成wifipoint数组
                     */
                    for (var i in jsonObj){
                        var  newLine = [jsonObj[i][1],jsonObj[i][0],jsonObj[i][2]];
                        point.push(newLine);
                    }
                    try {
                        //初始化echarts图层
                        var overlay = new Echarts3Layer(map, echarts);
                        var chartsContainer = overlay.getEchartsContainer();
                        var myChart = overlay.initECharts(chartsContainer);
                        //轨迹点数据
                        //热力图配置
                        var option = {
                            title: {
                                text: '',
                                left: 'center',
                                textStyle: {
                                    color: '#0c0c0c'
                                }
                            },
                            visualMap: {
                                min: -85,
                                max: -68,
                                splitNumber: 5,
                                show: false,
                                inRange: {
                                    // color: ['#d94d07', '#ea4007', '#baa808'].reverse()
                                    color: ['blue', 'blue', 'green', 'yellow', 'red']
                                },
                                textStyle: {
                                    color: '#080808'
                                }
                            },
                            geo: {
                                map: '',
                                show: false,
                                label: {
                                    emphasis: {
                                        show: false
                                    }
                                },
                                left: 0,
                                top: 0,
                                right: 0,
                                bottom: 0,
                                roam: false,
                                itemStyle: {
                                    normal: {
                                        areaColor: '#323c48',
                                        borderColor: '#111'
                                    },
                                    emphasis: {
                                        areaColor: '#2a333d'
                                    }
                                }
                            },
                            series: [{
                                type: 'heatmap', //effectScatter
                                coordinateSystem: 'geo',
                                data: point, //渲染数据【点数组】
                                pointSize: 15,  //点大小
                                blurSize: 60  //模糊大小
                            }]
                        };
                        // 使用刚指定的配置项和数据显示图表。
                        overlay.setOption(option);
                        console.log(point);

                    }
                    catch (e) {
                    }
                }
            );
        }
        var pointF1 = [];
        getHeatMap('bluetooth','1',pointF1,map1);
    });
</script>

</body>
</html>