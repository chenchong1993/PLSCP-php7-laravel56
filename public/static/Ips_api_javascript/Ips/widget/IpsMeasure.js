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
        "esri/dijit/Measurement",
        "esri/units",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/SimpleFillSymbol",
        "esri/Color",
        "dojo/text!./templates/IpsMeasure.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,
              Measurement,Units,SimpleLineSymbol,SimpleFillSymbol,Color,template) {
        var defaultIndex=100;
    return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            state:1,
            map:null,
            constructor: function(map){
            	this.map=map;
            },
            min_max:function () {
                if(this.state==1){
                    query(".mymin>span", this.domNode).removeClass("glyphicon-minus");
                    query(".mymin>span", this.domNode).addClass("glyphicon-chevron-right");
                    query(".mymin", this.domNode).attr("title","最大化");
                    query(".meatureitem", this.domNode).style("display", "none");
                    basefx.animateProperty({
                        node: this.id,
                        properties: {
                            width: {end: '150', units: "px"}
                        },
                        duration: 800
                    }).play();
                    this.state=0;
                }else
                if(this.state==0){
                    query(".mymin>span", this.domNode).removeClass("glyphicon-chevron-right");
                    query(".mymin>span", this.domNode).addClass("glyphicon-minus");
                    query(".mymin", this.domNode).attr("title","最小化");
                    query(".meatureitem", this.domNode).style("display", "block");
                    basefx.animateProperty({
                        node: this.id,
                        properties: {
                            width: {end: '300', units: "px"}
                        },
                        duration: 800
                    }).play();
                    this.state=1;
                }
            },
            close: function () {
                query(".mybtn-group", this.domNode).style("display", "none");
                query(".meatureitem", this.domNode).style("display", "none");
                basefx.fadeOut({
                    node: this.id,
                    onEnd: lang.hitch(this, function() {
                        this.destroy()
                        if(this.closeCallBack!=null)
                        {
                            this.closeCallBack(this);
                        }
                    }),
                    duration: 1000
                }).play();
            },
            changeZindex:function () {
                domStyle.set(this.domNode,"z-index",++defaultIndex);
            },
            meature:function () {
                var fill= new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID,
                    new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASHDOT,new Color([255,50,0]), 2),
                    new Color([0,50,200,0.25]));
                var line=new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([255,100,0]), 2);
                var mt= new Measurement({
                    map:this.map,
                    defaultAreaUnit: Units.SQUARE_KILOMETERS,
                    defaultLengthUnit: Units.KILOMETERS,
                    fillSymbol:fill,
                    lineSymbol:line
                },query("#measure", this.domNode)[0]);
                mt.startup();
            },
            startup: function () {
                domStyle.set(this.domNode,"position","absolute");
                domStyle.set(this.domNode,"top","100px");
                domStyle.set(this.domNode,"left","1000px");
                domStyle.set(this.domNode,"z-index",defaultIndex);
                basefx.fadeIn({
                    node: this.domNode,
                    duration: 1200
                }).play();
                this.meature();
                this.placeAt(win.body());
                //可移动
                this.a=new Moveable(this.domNode,{
                    handle:query(".mytitle",this.domNode)
                })
            }
        });
    });