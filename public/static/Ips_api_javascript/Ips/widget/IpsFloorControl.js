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
        "esri/layers/ArcGISDynamicMapServiceLayer",
        "dojo/parser",
        "dojo/text!./templates/IpsFloorControl.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,ArcGISDynamicMapServiceLayer,parser,template) {
        var defaultIndex=90;
    return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            status1:1,
            status2:0,
            map:null,
            floor1layer:null,
            floor2ayer:null,
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
                this.removeallport();
                this.release_();
                floor_num=0;
            },
            changeZindex:function () {
                domStyle.set(this.domNode,"z-index",++defaultIndex);
            },
            release_:function () {
                this.map=null;
                this.floor1layer=null;
                this.floor2ayer=null;
            },
            addfloor1:function () {
                this.map.addLayer(this.floor1layer);
                this.map.removeLayer(this.floor2layer);
                this.floor2layer=null;
                this.floor2layer=new ArcGISDynamicMapServiceLayer(config.TJserver.floortwo);
                //修改选择按钮颜色
                $('#floorone').css("color","#333");
                $('#floortwo').css("color","#fff");
                floor_num=1;
            },
            addfloor2:function () {
                this.map.addLayer(this.floor2layer);
                this.map.removeLayer(this.floor1layer);
                this.floor1layer=null;
                this.floor1layer=new ArcGISDynamicMapServiceLayer(config.TJserver.floorone);
                //修改选择按钮颜色
                $('#floortwo').css("color","#333");
                $('#floorone').css("color","#fff");
                floor_num=2;
            },
            removeallport:function () {
                this.map.removeLayer(this.floor1layer);
                this.map.removeLayer(this.floor2layer);
            },
            startup: function () {
                domStyle.set(this.domNode,"position","absolute");
                domStyle.set(this.domNode,"top","70px");
                domStyle.set(this.domNode,"left","150px");
                domStyle.set(this.domNode,"z-index",defaultIndex);
                basefx.fadeIn({
                    node: this.domNode,
                    duration: 800
                }).play();
                this.placeAt(win.body());
                //默认显示一层平面图
                this.floor1layer=new ArcGISDynamicMapServiceLayer(config.TJserver.floorone);
                this.floor2layer=new ArcGISDynamicMapServiceLayer(config.TJserver.floortwo);
                this.map.addLayer(this.floor1layer);
                $('#floorone').css("color","#333");
                floor_num=1;
                //可移动
                // this.a=new Moveable(this.domNode,{
                //     handle:query(".mytitle",this.domNode)
                // });
            }
        });
    });