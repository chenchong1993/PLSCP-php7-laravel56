define(["dojo/_base/declare","esri/layers/GraphicsLayer"],function(declare,GraphicsLayer){
    return declare("Ips.GraphicsLayer",GraphicsLayer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})