define(["dojo/_base/declare","esri/symbols/PictureMarkerSymbol"],function(declare,PictureMarkerSymbol){
    return declare("Ips.PictureMarkerSymbol",PictureMarkerSymbol,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})