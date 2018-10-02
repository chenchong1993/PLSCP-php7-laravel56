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
        "esri/layers/GraphicsLayer",
        "esri/geometry/Point",
        "esri/geometry/Polyline",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/TextSymbol",
        "esri/Color",
        "esri/graphic",
        "esri/SpatialReference",
        "dojo/request",
        "dojo/on",
        "dojo/parser",
        "dojo/text!./templates/IpsSimulationTrajectory.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,
              GraphicsLayer,Point,Polyline,SimpleMarkerSymbol,SimpleLineSymbol,TextSymbol,Color,Graphic,SpatialReference,
              request,on,parser,template) {
        var defaultIndex=100;
    return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            map:null,
            Pointlayer1:null,
            Linelayer1:null,
            Pointlayer2:null,
            Linelayer2:null,
            Pointlayer3:null,
            Linelayer3:null,
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
            initlayer:function () {
                this.Pointlayer1=new GraphicsLayer();
                this.Linelayer1=new GraphicsLayer();
                this.Pointlayer2=new GraphicsLayer();
                this.Linelayer2=new GraphicsLayer();
                this.Pointlayer3=new GraphicsLayer();
                this.Linelayer3=new GraphicsLayer();
            },
            addLayer1:function () {
                request.post("data/Trajectory1.json",{
                    data: {
                    },
                    handleAs:"json"
                }).then(lang.hitch(this,function (data) {
                    var linesSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([255,0,100]),1);
                    var pointSymbol = new SimpleMarkerSymbol();
                    pointSymbol.setColor(new esri.Color("red"));
                    pointSymbol.setOutline(new SimpleLineSymbol("solid", Color([255,255,255,1]), 1));
                    pointSymbol.setSize(4);
                    for(var i=0;i<data.length;i++){
                        var point = new Point(data[i][0],data[i][1]);
                        var graphicsP = new Graphic(point,pointSymbol);
                        this.Pointlayer1.add(graphicsP);
                    }
                    for(var i=0;i<data.length-1;i++){
                        var line=new Polyline([[data[i][0],data[i][1]],[data[i+1][0],data[i+1][1]]]);
                        var graphicsL = new Graphic(line,linesSymbol,null,null);
                        this.Pointlayer1.add(graphicsL);
                    }
                    this.map.addLayer(this.Linelayer1);
                    this.map.addLayer(this.Pointlayer1);
                }));
            },
            addLayer2:function () {
                request.post("data/Trajectory2.json",{
                    data: {
                    },
                    handleAs:"json"
                }).then(lang.hitch(this,function (data) {
                    var linesSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([0,255,100]),1);
                    var pointSymbol = new SimpleMarkerSymbol();
                    pointSymbol.setColor(new esri.Color("#00ff08"));
                    pointSymbol.setOutline(new SimpleLineSymbol("solid", Color([255,255,255,1]), 1));
                    pointSymbol.setSize(4);
                    for(var i=0;i<data.length;i++){
                        //点
                        var point = new Point(data[i][0],data[i][1]);
                        var graphicsP = new Graphic(point,pointSymbol);
                        this.Pointlayer2.add(graphicsP);
                    }
                    for(var i=0;i<data.length-1;i++){
                        //线
                        var line=new Polyline([[data[i][0],data[i][1]],[data[i+1][0],data[i+1][1]]]);
                        var graphicsL = new Graphic(line,linesSymbol,null,null);
                        this.Pointlayer2.add(graphicsL);
                    }
                    this.map.addLayer(this.Linelayer2);
                    this.map.addLayer(this.Pointlayer2);

                }));
            },
            addLayer3:function () {
                request.post("data/Trajectory3.json",{
                    data: {
                    },
                    handleAs:"json"
                }).then(lang.hitch(this,function (data) {
                    var linesSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([0,100,255]),1);
                    var pointSymbol = new SimpleMarkerSymbol();
                    pointSymbol.setColor(new esri.Color("#2ba1ff"));
                    pointSymbol.setOutline(new SimpleLineSymbol("solid", Color([255,255,255,1]), 1));
                    pointSymbol.setSize(4);
                    for(var i=0;i<data.length;i++){
                        //点
                        var point = new Point(data[i][0],data[i][1]);
                        var graphicsP = new Graphic(point,pointSymbol);
                        this.Pointlayer3.add(graphicsP);
                    }
                    for(var i=0;i<data.length-1;i++){
                        //线
                        var line=new Polyline([[data[i][0],data[i][1]],[data[i+1][0],data[i+1][1]]]);
                        var graphicsL = new Graphic(line,linesSymbol,null,null);
                        this.Pointlayer3.add(graphicsL);
                    }
                    this.map.addLayer(this.Linelayer3);
                    this.map.addLayer(this.Pointlayer3);

                }));
            },
            clear1:function () {
                this.map.removeLayer(this.Linelayer1);
                this.map.removeLayer(this.Pointlayer1);
                this.Linelayer1.clear();
                this.Pointlayer1.clear();
            },
            clear2:function () {
                this.map.removeLayer(this.Linelayer2);
                this.map.removeLayer(this.Pointlayer2);
                this.Linelayer2.clear();
                this.Pointlayer2.clear();
            },
            clear3:function () {
                this.map.removeLayer(this.Linelayer3);
                this.map.removeLayer(this.Pointlayer3);
                this.Linelayer3.clear();
                this.Pointlayer3.clear();
            },
            clear:function(){
                this.clear1();
                this.clear2();
                this.clear3();
                this.Linelayer1=null;
                this.Pointlayer1=null;
                this.Linelayer2=null;
                this.Pointlayer2=null;
                this.Linelayer3=null;
                this.Pointlayer3=null;
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
                this.initlayer();
                //可移动
                this.a=new Moveable(this.domNode,{
                    handle:query(".mytitle",this.domNode)
                });
            }
        });
    });