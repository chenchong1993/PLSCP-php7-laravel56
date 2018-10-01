define(["dojo/_base/declare","esri/layers/ArcGISDynamicMapServiceLayer"],function(declare,DynamicMapServiceLayer){
    return declare("Ips.Map",DynamicMapServiceLayer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})