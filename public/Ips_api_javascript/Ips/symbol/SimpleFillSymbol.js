define(["dojo/_base/declare","esri/symbols/SimpleFillSymbol"],function(declare,SimpleFillSymbol){
    return declare("Ips.SimpleFillSymbol",SimpleFillSymbol,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})