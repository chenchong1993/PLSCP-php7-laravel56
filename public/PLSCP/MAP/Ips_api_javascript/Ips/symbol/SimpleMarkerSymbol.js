define(["dojo/_base/declare","esri/symbols/SimpleMarkerSymbol"],function(declare,SimpleMarkerSymbol){
    return declare("Ips.SimpleMarkerSymbol",SimpleMarkerSymbol,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})