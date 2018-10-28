@extends('common.layouts')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">基础地图</h4>
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
        require([
            "Ips/map",
            "src/Echarts3Layer",
            "Ips/layers/DynamicMapServiceLayer",
            "dojo/on",
            "dojo/dom",
            "dojo/domReady!"
        ], function (Map,Echarts3Layer,DynamicMapServiceLayer,on,dom){
            var map = new Map("map", {
                logo:false,
                center: [114.3489254,38.2477279]
            });

            function addHeatMap(chartsContainer,overlay,point) {
                try {
                    //初始化echarts图层
                    var myChart = overlay.initECharts(chartsContainer);

                    //轨迹点数据

                    //热力图配置
                    var option = {
                        title: {
                            text: '',
                            left: 'center',
                            textStyle: {
                                color: '#fff'
                            }
                        },
                        visualMap: {
                            min: 0,
                            max: 500,
                            splitNumber: 5,
                            inRange: {
                                color: ['#d94e5d', '#eac736', '#50a3ba'].reverse()
                            },
                            textStyle: {
                                color: '#fff'
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
                            // pointSize: 8,  //点大小
                            // blurSize: 30  //模糊大小
                        }]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    overlay.setOption(option);
                }
                catch (e) {

                }
            }


            //初始化F1楼层平面图
            var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
            map.addLayer(f2);
            var overlay = new Echarts3Layer(map, echarts);
            var chartsContainer = overlay.getEchartsContainer();

            var point = [
                [114.3488542, 38.2477700, 500],
                [114.3489, 38.2477700, 500]
            ];

            addHeatMap(chartsContainer,overlay,point);

            on(dom.byId("render1"),"click",function () {

            });
            on(dom.byId("render2"),"click",function () {

            });
            on(dom.byId("render3"),"click",function () {

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