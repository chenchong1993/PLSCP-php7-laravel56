define(["dojo/_base/declare","esri/layers/ArcGISDynamicMapServiceLayer"],function(declare,MapServiceLayer){
    return declare("Ips.DynamicMapServiceLayer",MapServiceLayer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})