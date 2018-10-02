<!DOCTYPE html>
<html style="height: 100%">
<head>
    <meta charset="utf-8">
    <title>历史轨迹渲染</title>
</head>
<body style="height: 100%; margin: 0">
<div id="container" style="height: 100%"></div>
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/echarts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/echarts-gl.js')}}"></script>
<script src='{{asset('js/mapbox-gl.js')}}'></script>
<script type="text/javascript">
    //mapbox地图许可，需要自己注册一个mapbox账户
    mapboxgl.accessToken = 'pk.eyJ1IjoieXlhbmcxOTkzIiwiYSI6ImNqOTl4ZXVzZTBxeDEycXBhNXlsa2F3NWcifQ.QFC0tXCO4wYOvX6IoKSB4g';
    //初始化一个echarts实例
    var myChart = echarts.init(document.getElementById('container'));
    //ajax加载模拟轨迹
    $.post("data/moni.json",function (data) {
        var taxiRoutes = [];  //定义数组并进行每条线的颜色样式设置
        var hStep = 300 / (data.length - 1);
        for (var i in data) {
            taxiRoutes.push({
                coords: data[i].coords, //点坐标
                lineStyle: {
                    color: echarts.color.modifyHSL('#5A94DF', Math.round(hStep * i))
                }
            });
        }
        //chart配置
        myChart.setOption({
            title: {   //标题
                top: 8,
                left: 'center',
                text: '多用户历史轨迹',
                textStyle: {
                    color: '#fff',
                    fontSize: 16,
                },
                subtext: '石家庄市桥西区',
            },
            mapbox: {
                center: [114.446166,38.047284],    //地图中心点经纬度
                zoom: 13,   //地图缩放级别
                //pitch: 50,
                //bearing: -10,
                altitudeScale: 2,
                style: 'mapbox://styles/mapbox/dark-v9',   //'mapbox://styles/mapbox/streets-v8',
                postEffect: {
                    enable: true,
                    SSAO: {
                        enable: true,
                        radius: 2,
                        intensity: 1.5
                    }
                },
                light: {
                    main: {
                        intensity: 1,
                        shadow: true,
                        shadowQuality: 'high'
                    },
                    ambient: {
                        intensity: 0.
                    },
                    ambientCubemap: {
                        exposure: 1,
                        diffuseIntensity: 0.5
                    }
                }
            },
            series: [{
                type: 'lines3D',
                coordinateSystem: 'mapbox',
                effect: {
                    show: true,
                    constantSpeed: 3,
                    trailWidth: 1.5,
                    trailLength: 0.2,
                    trailOpacity: 0.7,
                    spotIntensity: 10
                },
                blendMode: 'lighter',
                polyline: true,
                lineStyle: {
                    width: 0.1,
                    color: '#ff270a',
                    opacity: 0
                },
                data:taxiRoutes
            }]
        });
    })

</script>
</body>
</html>