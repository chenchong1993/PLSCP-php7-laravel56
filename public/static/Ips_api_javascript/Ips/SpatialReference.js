define(["dojo/_base/declare","esri/SpatialReference"],function(declare,SpatialReference){
    return declare("Ips.SpatialReference",SpatialReference,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})