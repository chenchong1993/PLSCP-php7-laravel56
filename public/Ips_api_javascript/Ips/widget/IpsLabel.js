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
        "esri/layers/GraphicsLayer",
        "esri/graphic",
        "esri/InfoTemplate",
        "esri/geometry/Point",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/PictureMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/SimpleFillSymbol",
        "esri/toolbars/draw",
        "esri/Color",
        "dojo/on",
        "dojo/text!./templates/IpsLabel.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,
              Measurement,Units,GraphicsLayer,Graphic,InfoTemplate,Point,SimpleMarkerSymbol,PictureMarkerSymbol,SimpleLineSymbol,SimpleFillSymbol,
              Draw,Color,on,template) {
        var defaultIndex=100;
    return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            state:1,
            map:null,
            draw:null,
            constructor:function(map){
            	this.map=map;
            },
            min_max:function () {
                if(this.state==1){
                    query(".mymin>span", this.domNode).removeClass("glyphicon-minus");
                    query(".mymin>span", this.domNode).addClass("glyphicon-chevron-right");
                    query(".mymin", this.domNode).attr("title","最大化");
                    query(".labelitem", this.domNode).style("display", "none");
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
                    query(".labelitem", this.domNode).style("display", "block");
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
                query(".labelitem", this.domNode).style("display", "none");
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
                this.removelabel();
                this.stopdraw();
            },
            changeZindex:function () {
                domStyle.set(this.domNode,"z-index",++defaultIndex);
            },
            activedraw:function(){
                this.draw.activate(Draw.POINT);
            },
            addLabel:function (evt) {
                var name=query("#lname",this.domNode)[0].value;
                var attr=query("#lattr",this.domNode)[0].value;
                var marker = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/marker.png",20,20);
                marker.setOffset(0, 10)
                //信息模板
                var infoTemplate = new InfoTemplate();
                infoTemplate.setTitle("标注点");
                infoTemplate.setContent("<b>名称:</b><span>"+name+"</span><br>"+
                    "<b>属性信息:</b><span>"+attr+"</span>");
                var graphic = new Graphic(evt.geometry,marker,"",infoTemplate);
                this.map.graphics.add(graphic);
            },
            removelabel:function () {
                this.map.graphics.clear();
            },
            stopdraw:function () {
                this.draw.deactivate();
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
                this.draw=new Draw(this.map);
                this.draw.on("draw-end", this.addLabel);
                this.placeAt(win.body());
                //可移动
                this.a=new Moveable(this.domNode,{
                    handle:query(".mytitle",this.domNode)
                })
            }
        });
    });