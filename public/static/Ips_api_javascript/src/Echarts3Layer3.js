define(["dojo/_base/declare",
		"dojo/_base/lang",
		"esri/geometry/Point",
		"esri/geometry/ScreenPoint"],
	function(declare,t,n,i){
		return declare("Echarts3Layer",null,{
			name:"Echarts3Layer",
			_map:null,
			_ec:null,
			_geoCoord:[],
			_option:null,
			_mapOffset:[0,0],
			constructor:function(map,t){
				this._map=map;
				var n=this._echartsContainer=document.createElement("div");
				n.style.position="absolute",
				n.style.height=map.height+"px",
				n.style.width=map.width+"px",
				n.style.top=0,
				n.style.left=0,
				map.__container.appendChild(n),
				this._init(map,t,n)},
				_init:function(map,t){
					//console.log('<a href="https://github.com/wandergis/arcgis-echarts3">develop by wandergis</a>');
					var o=this;
					o._map=map,
					o._ec=t,
					o.getEchartsContainer=function(){
						return o._echartsContainer},
					o.getMap=function(){
						return o._map},
					o.geoCoord2Pixel=function(pixel){
						var t=new n(pixel[0],pixel[1]),
						i=o._map.toScreen(t);
						return[i.x,i.y]
					},
					o.pixel2GeoCoord=function(pixel){
						var t=o._map.toMap(new i(pixel[0],pixel[1]));
						return[t.lng,t.lat]
					},
					o.initECharts=function(){
						return o._ec=t.init.apply(o,arguments),
						o._ec.Geo.prototype.dataToPoint=function(pixel){
							var t=new n(pixel[0],pixel[1]),
							i=o._map.toScreen(t);
							return[i.x,i.y]
						},
						o._bindEvent(),o._ec
					},
					o.getECharts=function(){
						return o._ec
					},
					o.setOption=function(map,t){
						o._option=map,o._ec.setOption(map,t)
					},
					o.deleteEcharts=function(){
						o._echartsContainer.parentNode.removeChild(o._echartsContainer);
					},
					o._bindEvent=function(){
						o._map.on("zoom-end",function(e){
							o._ec.resize(),
							o._echartsContainer.style.visibility="visible"
						}),
						o._map.on("zoom-start",function(e){
							o._echartsContainer.style.visibility="hidden"
						}),
						o._map.on("pan",function(e){
							o._echartsContainer.style.visibility="hidden"
						}),
						o._map.on("pan-end",function(e){
							o._ec.resize(),
							o._echartsContainer.style.visibility="visible"
						}),
						o._map.on("resize",function(){
							var e=o._echartsContainer.parentNode.parentNode.parentNode;
							o._mapOffset=[-parseInt(e.style.left)||0,-parseInt(e.style.top)||0],
							o._echartsContainer.style.left=o._mapOffset[0]+"px",
							o._echartsContainer.style.top=o._mapOffset[1]+"px",
							setTimeout(function(){
								o._map.resize(),o._map.reposition(),
								o._ec.resize()
							},200),
							o._echartsContainer.style.visibility="visible"
						}),
						o._ec.getZr().on("dragstart",function(e){
							
						}),
						o._ec.getZr().on("dragend",function(e){
							
						}),
						o._ec.getZr().on("mousewheel",function(e){
							o._lastMousePos=o._map.toMap(new i(e.event.x,e.event.y));
							var t=e.wheelDelta,n=o._map,a=n.getZoom();
							t=t>0?Math.ceil(t):Math.floor(t),
							t=Math.max(Math.min(t,4),-4),
							t=Math.max(n.getMinZoom(),
							Math.min(n.getMaxZoom(),a+t))-a,o._delta=0,
							o._startTime=null,t&&n.setZoom(a+t)
						})
					}
				}
		    				
		})
	});