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
        "esri/geometry/Point",
        "dojo/parser",
        "dojo/text!./templates/IpsRegion.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,Point,parser,template) {
        var defaultIndex=90;
    return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            status1:1,
            status2:0,
            map:null,
            streetlayer:null,
            imagelayer:null,
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
            selectregion:function (data) {
                var centerpoint=new Point(data[0],data[1]);
                this.map.centerAt(centerpoint);
            },
            clickTJ:function () {
                var lonlat=[121.498, 31.285];
                this.selectregion(lonlat);
            },
            click54S:function(){
                var lonlat=[114.433,38.0444];
                this.selectregion(lonlat);
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
                //可移动
                // this.a=new Moveable(this.domNode,{
                //     handle:query(".mytitle",this.domNode)
                // });
            }
        });
    });