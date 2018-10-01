define(["dojo/_base/declare",
        "dijit/_Widget",
        "dojo/_base/lang",
        "dojo/dom-geometry",
        "dojo/dom-style",
        "dojo/_base/fx",
        "dojo/fx",
        "dojo/query",
        "dijit/_TemplatedMixin",
        "dojo/_base/window",
        "dojo/dnd/Moveable",
        "esri/tasks/RouteTask",
        "esri/tasks/RouteParameters",
        "esri/tasks/FeatureSet",
        "esri/toolbars/draw",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/TextSymbol",
        "esri/Color",
        "esri/graphic",
        "esri/SpatialReference",
        "dojo/on",
        "dojo/parser",
        "dojo/text!./templates/IpsNetworkAnalysis.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,
              RouteTask,RouteParameters,FeatureSet,Draw,SimpleMarkerSymbol,SimpleLineSymbol,TextSymbol,Color,Graphic,SpatialReference,
              on,parser,template) {
        var defaultIndex=100;
        return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            map:null,
            routeanalysis1:null,
            routeanalysis2:null,
            routeanalysis3:null,
            routeParas:null,
            selectPointID:null,
            status:0,
            constructor:function (map) {
                this.map=map;
            },
            close: function () {
                basefx.fadeOut({
                    node: this.id,
                    onEnd: lang.hitch(this, function() {
                        this.destroy()
                        if(this.closeCallBack!=null)
                        {
                            this.closeCallBack(this);
                        }
                    }),
                    duration: 600
                }).play();
                this.clear();
                this.status=0;
            },
            changeZindex:function () {
                domStyle.set(this.domNode,"z-index",++defaultIndex);
            },
            initParas:function(){
                this.routeanalysis1 = new RouteTask(config.FFSserver.route1);
                this.routeanalysis2 = new RouteTask(config.FFSserver.route2);
                this.routeanalysis3 = new RouteTask(config.FFSserver.route3);
                this.routeParas=new RouteParameters();
                //障碍点，但是此时障碍点为空
                this.routeParas.barriers = new FeatureSet();
                //停靠点，但是此时停靠点为空
                this.routeParas.stops = new FeatureSet();
                //路径是否有方向
                this.routeParas.returnDirections = false;
                //是否返回路径，此处必须返回
                this.routeParas.returnRoutes = true;
                //空间参考
                this.routeParas.outSpatialReference = new SpatialReference(4326);
            },
            addStopPoint:function () {
                this.selectPointID = 1;
                this.status=1;
                //定义停靠点的符号
                var stopSymbol = new SimpleMarkerSymbol();
                stopSymbol.style = SimpleMarkerSymbol.STYLE_DIAMOND;
                stopSymbol.setSize(10);
                stopSymbol.setColor(new Color("#ffb000"));
                on(this.map, "click", lang.hitch(this,function(evt){
                    if(this.status==1){
                        //获得停靠点的坐标
                        var pointStop=evt.mapPoint;
                        var gr=new Graphic(pointStop,stopSymbol);
                        //构建停靠点的参数
                        this.routeParas.stops.features.push(gr);

                        //如果selectPointID不等于0，将点的坐标在地图上显示出来
                        if (this.selectPointID != 0) {
                            this.addTextPoint("停靠点", pointStop, stopSymbol);
                            this.selectPointID = 0;
                        }
                    }
                }));
            },
            addTextPoint:function(text,point,symbol) {
                //文本符号：文本信息，点坐标，符号
                var textSymbol = new TextSymbol(text);
                textSymbol.setColor(new Color([128, 0, 0]));
                textSymbol.setOffset(0, 8)
                var graphicText = Graphic(point, textSymbol);
                var graphicpoint = new Graphic(point, symbol);
                //用默认的图层添加
                this.map.graphics.add(graphicpoint);
                //用默认的图层添加
                this.map.graphics.add(graphicText);
            },
            anlysis:function () {
                if  (this.routeParas.stops.features.length == 0 )
                {
                    alert("输入参数不全，无法分析");
                    return;
                }
                //执行路径分析函数
                if(floor_num==1){
                    this.routeanalysis1.solve(this.routeParas, this.showRoute);
                }
                if(floor_num==2){
                    this.routeanalysis2.solve(this.routeParas, this.showRoute);
                }
                if(floor_num==3){
                    this.routeanalysis3.solve(this.routeParas, this.showRoute);
                }
            },
            showRoute:function (solveResult) {
                //路径分析的结果
                var routeResults = solveResult.routeResults;
                //路径分析的长度
                var res = routeResults.length;
                //路径的符号
                routeSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
                if (res > 0) {
                    for (var i = 0; i < res; i++) {
                        var graphicroute = routeResults[i];
                        var graphic = graphicroute.route;
                        graphic.setSymbol(routeSymbol);
                        map.graphics.add(graphic);
                    }
                }
                else {
                    alert("没有返回结果");
                }
            },
            clear:function () {
                this.map.graphics.clear();
                this.routeParas=null;
                this.selectPointID=null;
                this.initParas();
            },
            startup: function () {
                domStyle.set(this.domNode,"position","absolute");
                domStyle.set(this.domNode,"top","70px");
                domStyle.set(this.domNode,"left","800px");
                domStyle.set(this.domNode,"z-index",defaultIndex);
                basefx.fadeIn({
                    node: this.domNode,
                    duration: 800
                }).play();
                this.placeAt(win.body());
                //初始化属性
                this.initParas();
                //可移动
                this.a=new Moveable(this.domNode,{
                    handle:query(".mytitle",this.domNode)
                });
            }
        });
    });